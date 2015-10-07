<?php
namespace fhu\TableData\Layout;

use fhu\TableData\Exception\HeaderDoesNoMatchDataColumnCount;
use fhu\TableData\Exception\HeaderNotSetException;
use fhu\TableData\Model\Config;
use fhu\TableData\Table;

class LayoutManager
{
    /**
     * @var Config
     */
    protected $config;

    /**
     * @var LayoutInterface
     */
    protected $layout;

    /**
     * @param Config $config
     * @param LayoutInterface $layout
     */
    public function __construct(Config $config, LayoutInterface $layout)
    {
        $this->config = $config;
        $this->layout = $layout;
    }

    /**
     * @return string
     * @throws HeaderDoesNoMatchDataColumnCount
     * @throws HeaderNotSetException
     */
    public function render()
    {
        $this->config->checkConfiguration();

        $content = $this->renderHeader();
        $content .= $this->renderBody();
        $content .= $this->renderFooter();

        return $content;
    }

    protected function renderHeader()
    {
        $content = '';
        $content .= $this->layout->beforeTable($this->config->getId());
        $content .= $this->layout->beforeHeader();

        $currentCell = 0;
        foreach ($this->config->getHeader() as $value) {
            $rowId = $this->config->getRowId($currentCell);
            $width = $this->config->getColumnSize($rowId);

            $orderingColumn = $this->config->getOrderingColumn();

            $link = $orderingColumnOrder = null;
            if ($this->config->showOrder($rowId)) {
                $orderingColumnOrder = $this->config->getOrder();
                if ($rowId == $orderingColumn) {
                    $linkOrder = $this->config->getNextDirection($orderingColumnOrder);
                    $link = $this->config->getHeaderLink($rowId, $linkOrder);
                } else {
                    $orderingColumnOrder = null;
                    $link = $this->config->getHeaderLink($rowId, Table::DIRECTION_DOWN);
                }
            }

            $content .= $this->layout->beforeHeaderCell($currentCell, $orderingColumnOrder, $width, $link);
            $content .= $this->renderValue($rowId, $value, $currentCell, -1, true);
            $content .= $this->layout->afterHeaderCell($currentCell, $orderingColumnOrder, $width, $link);

            $currentCell++;
        }

        $content .= $this->layout->afterHeader();
        $content .= $this->layout->beforeTableBody();

        return $content;
    }

    protected function renderBody()
    {
        $content         = '';
        $currentRow      = 0;
        $headerCellCount = count($this->config->getHeader());

        /**
         * @var array $row
         */
        foreach ($this->config->getData() as $row) {
            $currentCell = 0;

            $cellCount = count($row);
            if ($headerCellCount != $cellCount) {
                throw new HeaderDoesNoMatchDataColumnCount('Number of header cells are different of body row cells at line ' . $currentRow);
            }

            $content .= $this->layout->beforeRow($currentRow);

            /**
             * @var mixed $cell
             */
            foreach ($row as $value) {
                $content .= $this->renderCell($value, $currentRow, $currentCell);
                $currentCell++;
            }

            $content .= $this->layout->afterRow($currentRow);

            $currentRow++;
        }

        return $content;
    }

    protected function renderCell($value, $currentRow, $currentCell)
    {
        $content = '';

        $rowId = $this->config->getRowId($currentCell);
        $width = $this->config->getColumnSize($rowId);

        $content .= $this->layout->beforeRowCell($currentRow, $currentCell, $width);
        $content .= $this->renderValue($rowId, $value, $currentCell, $currentRow);
        $content .= $this->layout->afterRowCell($currentRow, $currentCell, $width);

        return $content;
    }

    protected function renderFooter()
    {
        $content = $this->layout->afterTableBody();
        $content .= $this->layout->afterTable($this->config->getId());

        return $content;
    }

    protected function renderValue($rowId, $value, $currentCell, $currentRow, $header = false)
    {
        $content = '';

        if ($this->config->hasFilter($rowId, $header)) {
            $filters = $this->config->getFilters($rowId, $header);

            /**
             * @var array $filter
             */
            foreach ($filters as $filter) {
                $filterCallback = $filter['callable'];
                $userData = $filter['data'];

                $content .= $filterCallback($value, $currentCell, $currentRow, $userData);
            }
        } else {
            $content .= $value;
        }

        return $content;
    }
}