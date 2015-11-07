<?php
namespace fhu\TableData\Model;

use fhu\TableData\Exception\HeaderDoesNoMatchDataColumnCount;
use fhu\TableData\Exception\HeaderNotSetException;
use fhu\TableData\Filters\Struct\CallbackInfo;
use fhu\TableData\Layout\LayoutAbstract;
use fhu\TableData\Layout\LayoutInterface;
use fhu\TableData\Params\Body;
use fhu\TableData\Params\Header;
use fhu\TableData\Params\HeaderCell;
use fhu\TableData\Params\Row;
use fhu\TableData\Params\RowCell;
use fhu\TableData\Table;
use fhu\TableData\Params\Table as TableParam;

class LayoutManager
{
    /**
     * @var Config
     */
    protected $config;

    /**
     * @var LayoutAbstract
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
        $this->layout->setConfig($this->config);

        $content = $this->renderHeader();
        $content .= $this->renderBody();
        $content .= $this->renderFooter();

        return $content;
    }

    protected function renderHeader()
    {
        $tableParam = new TableParam();
        $headerParam = new Header();
        $bodyParam = new Body();
        $headerCellParam = new HeaderCell();

        $content = '';
        $content .= $this->layout->beforeTable($tableParam);
        $content .= $this->layout->beforeHeader($headerParam);

        $currentCell = 0;
        $headerValues = $this->config->getHeader();
        foreach ($headerValues as $value) {
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

            $headerCellParam->columnIndex = $currentCell;
            $headerCellParam->link = $link;
            $headerCellParam->order = $orderingColumnOrder;
            $headerCellParam->width = $width;

            $content .= $this->layout->beforeHeaderCell($headerCellParam);
            $content .= $this->renderValue($rowId, $value, $currentCell, -1, true, $headerValues);
            $content .= $this->layout->afterHeaderCell($headerCellParam);

            $currentCell++;
        }

        $content .= $this->layout->afterHeader($headerParam);
        $content .= $this->layout->beforeTableBody($bodyParam);

        return $content;
    }

    protected function renderBody()
    {
        $rowParam = new Row();

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

            $rowParam->rowIndex = $currentCell;

            $content .= $this->layout->beforeRow($rowParam);

            /**
             * @var mixed $cell
             */
            foreach ($row as $value) {
                $content .= $this->renderCell($value, $currentRow, $currentCell, $row);
                $currentCell++;
            }

            $content .= $this->layout->afterRow($rowParam);

            $currentRow++;
        }

        return $content;
    }

    protected function renderCell($value, $currentRow, $currentCell, &$row)
    {
        $rowCellParam = new RowCell();

        $content = '';

        $rowId = $this->config->getRowId($currentCell);
        $width = $this->config->getColumnSize($rowId);

        $rowCellParam->width = $width;
        $rowCellParam->columnIndex = $currentCell;
        $rowCellParam->rowIndex = $currentRow;

        $content .= $this->layout->beforeRowCell($rowCellParam);
        $content .= $this->renderValue($rowId, $value, $currentCell, $currentRow, false, $row);
        $content .= $this->layout->afterRowCell($rowCellParam);

        return $content;
    }

    protected function renderFooter()
    {
        $tableParam = new \fhu\TableData\Params\Table();
        $bodyParam = new Body();

        $content = $this->layout->afterTableBody($bodyParam);
        $content .= $this->layout->afterTable($tableParam);

        return $content;
    }

    protected function renderValue($rowId, $value, $currentCell, $currentRow, $header = false, &$row)
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

                $callbackInfo = new CallbackInfo();
                $callbackInfo->rowIndex = $currentRow;
                $callbackInfo->cellIndex = $currentCell;
                $callbackInfo->id = $rowId;
                $callbackInfo->rowValues = &$row;
                $callbackInfo->userData = $userData;

                $content .= $filterCallback($value, $callbackInfo);

                unset($callbackInfo);
            }
        } else {
            $content .= $value;
        }

        return $content;
    }
}