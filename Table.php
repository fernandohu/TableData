<?php
namespace fhu\TableData;

use fhu\TableData\Exception\EmptyHeadersException,
    fhu\TableData\Exception\HeaderNotSetException,
    fhu\TableData\Exception\HeaderDoesNoMatchDataColumnCount,
    fhu\TableData\Exception\InvalidHeadersException,
    fhu\TableData\Exception\LinkParameterNotSetException;

class Table
{
    /**
     * @var LayoutInterface
     */
    protected $layout;

    /**
     * @var array
     */
    protected $data = [];

    /**
     * @var array
     */
    protected $header = [];

    /**
     * @var array
     */
    protected $showOrdering = [];

    /**
     * @var array
     */
    protected $columnSizes = [];

    /**
     * @var array
     */
    protected $filters = [];

    /**
     * @var array
     */
    protected $cachedRowIds = [];

    /**
     * @var string
     */
    protected $link = '';

    /**
     * @var string
     */
    protected $orderingColumnOrder;

    /**
     * @var string
     */
    protected $orderingColumn;

    /**
     * @var string
     */
    protected $id = 'container';

    /**
     * Direction constants
     */
    const DIRECTION_UP = 'desc';
    const DIRECTION_DOWN = 'asc';
    const DIRECTION_NONE = 'none';

    /**
     * @param LayoutInterface $layout
     */
    public function __construct($layout)
    {
        $this->layout = $layout;
    }

    /**
     * The key is the row id, and the value is the row value.
     *
     * @param array $cells
     * @throws EmptyHeadersException
     * @throws InvalidHeadersException
     */
    public function setHeader(array $cells)
    {
        if (count($cells) == 0) {
            throw new EmptyHeadersException('The specified header is empty.');
        }

        if (is_numeric(key($cells))) {
            throw new InvalidHeadersException('Headers must be passed with both key and value as string. The key represents the Row Id, and the value is represents the Header Title.');
        }

        $this->header = $cells;
    }

    /**
     * @param string $rowId
     * @param string $direction
     * @return mixed|string
     */
    public function getHeaderLink($rowId = '', $direction = self::DIRECTION_DOWN)
    {
        $link = $this->link;

        if ($rowId) {
            $link = $this->link;
            $link = str_replace('%ROW_ID%', $rowId, $link);
            $link = str_replace('%DIRECTION%', $direction, $link);

            return $link;
        }

        return $link;
    }

    public function getNextDirection($direction)
    {
        switch ($direction) {
            case self::DIRECTION_DOWN:
                return self::DIRECTION_UP;
                break;

            case self::DIRECTION_UP:
                return self::DIRECTION_NONE;
                break;

            case self::DIRECTION_NONE:
                return self::DIRECTION_DOWN;
                break;
        }
    }

    /**
     * @param $link
     * @throws LinkParameterNotSetException
     */
    public function setHeaderLink($link)
    {
        if (strpos($link, '%ROW_ID%') === false) {
            throw new LinkParameterNotSetException('%ROW_ID% parameter not specified while setting the Header Link.');
        }

        if (strpos($link, '%DIRECTION%') === false) {
            throw new LinkParameterNotSetException('%DIRECTION% parameter not specified while setting the Header Link.');
        }

        $this->link = $link;
    }

    /**
     * @return array
     */
    public function getColumnSizes()
    {
        return $this->columnSizes;
    }

    /**
     * Array of boolean values. True is ASC, false is DESC. Use null if you don't want to display
     * the order icon.
     *
     * @param array $sizes
     */
    public function setColumnSizes(array $sizes)
    {
        if (count($sizes) && !is_numeric(key($sizes))) {
            $this->columnSizes = $sizes;
        } else {
            reset($sizes);
            $this->columnSizes = [];
            foreach ($this->header as $key => $value) {
                $this->columnSizes[$key] = current($sizes);
                if (next($sizes) === false)
                    break;
            }
        }
    }

    /**
     * Array of boolean values. Keys are ROW IDs, and values must be true or false.
     *
     * @param array
     */
    public function enableOrdering(array $ordering)
    {
        if (count($ordering) && !is_numeric(key($ordering))) {
            $this->showOrdering = $ordering;
        } else {
            reset($ordering);
            $this->showOrdering = [];
            foreach ($this->header as $key => $value) {
                $this->showOrdering[$key] = current($ordering);
                if (next($ordering) === false)
                    break;
            }
        }
    }

    /**
     * @return array
     */
    public function getEnabledOrdering()
    {
        return $this->showOrdering;
    }

    /**
     * Returns TRUE if ordering is enabled for the specified ROW ID.
     *
     * @param string $rowId
     * @return bool
     */
    public function showOrder($rowId)
    {
        if (isset($this->showOrdering[$rowId]) && $this->showOrdering[$rowId] == true) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Sets the current ORDERING.
     *
     * @param string $order
     */
    public function setOrder($order = self::DIRECTION_DOWN)
    {
        $this->orderingColumnOrder = $order;
    }

    /**
     * Gets the current ORDERING.
     *
     * @return string
     */
    public function getOrder()
    {
        return $this->orderingColumnOrder;
    }

    /**
     * Sets the columns that is being ordered.
     *
     * @param string $rowId
     */
    public function setOrderingColumn($rowId)
    {
        $this->orderingColumn = $rowId;
    }

    /**
     * Gets the column that is being ordered.
     *
     * @return string
     */
    public function getOrderingColumn()
    {
        return $this->orderingColumn;
    }

    /**
     * @return array
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * Multidimensional array with values representing cell values of the table body. Indexes are ignored, only
     * array values are used.
     *
     * @param array $data
     */
    public function setData(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->getData();
    }

    /**
     * Filters can be used to change data before displaying it.
     *
     * @param string $rowId
     * @param bool $header
     * @param callable $callback
     * @param mixed $data
     */
    public function setFilter($rowId, $header = false, callable $callback = null, $data = [])
    {
        if (!isset($this->filters[$header][$rowId])) {
            $this->filters[$header][$rowId] = [];
        }

        $filter = [
            'callable' => $callback,
            'data' => $data,
        ];

        $this->filters[$header][$rowId][] = $filter;
    }

    /**
     * @param string $rowId
     * @param bool $header
     * @return array
     */
    public function getFilters($rowId, $header = false)
    {
        if (isset($this->filters[$header][$rowId])) {
            return $this->filters[$header][$rowId];
        }

        return [];
    }

    /**
     * @param string $rowId
     * @param bool $header
     * @return bool
     */
    public function hasFilter($rowId, $header = false)
    {
        return isset($this->filters[$header][$rowId]);
    }

    /**
     * @param $headerIndex
     * @return string
     */
    public function getRowId($headerIndex)
    {
        if (!isset($this->cachedRowIds[$headerIndex])) {
            $headerCopy = $this->header;

            reset($headerCopy);
            for ($i = 0; $i < $headerIndex; $i++) {
                next($headerCopy);
            }

            $this->cachedRowIds[$headerIndex] = key($headerCopy);
        }

        return $this->cachedRowIds[$headerIndex];
    }

    /**
     * @param string $rowId
     * @return int
     */
    public function getColumnSize($rowId) {
        if (isset($this->columnSizes[$rowId])) {
            return $this->columnSizes[$rowId];
        } else {
            return '';
        }
    }

    /**
     * @return string
     * @throws HeaderDoesNoMatchDataColumnCount
     * @throws HeaderNotSetException
     */
    public function render()
    {
        $this->checkConfiguration();

        $content = $this->renderHeader();
        $content .= $this->renderBody();
        $content .= $this->renderFooter();

        return $content;
    }

    protected function renderHeader()
    {
        $content = '';
        $content .= $this->layout->beforeTable($this->id);
        $content .= $this->layout->beforeHeader();

        $currentCell = 0;
        foreach ($this->header as $value) {
            $rowId = $this->getRowId($currentCell);
            $width = $this->getColumnSize($rowId);

            $orderingColumn = $this->getOrderingColumn();

            $link = $orderingColumnOrder = null;
            if ($this->showOrder($rowId)) {
                $orderingColumnOrder = $this->getOrder();
                if ($rowId == $orderingColumn) {
                    $linkOrder = $this->getNextDirection($orderingColumnOrder);
                    $link = $this->getHeaderLink($rowId, $linkOrder);
                } else {
                    $orderingColumnOrder = null;
                    $link = $this->getHeaderLink($rowId, self::DIRECTION_DOWN);
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
        $headerCellCount = count($this->header);

        /**
         * @var array $row
         */
        foreach ($this->data as $row) {
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

        $rowId = $this->getRowId($currentCell);
        $width = $this->getColumnSize($rowId);

        $content .= $this->layout->beforeRowCell($currentRow, $currentCell, $width);
        $content .= $this->renderValue($rowId, $value, $currentCell, $currentRow);
        $content .= $this->layout->afterRowCell($currentRow, $currentCell, $width);

        return $content;
    }

    protected function renderFooter()
    {
        $content = $this->layout->afterTableBody();
        $content .= $this->layout->afterTable($this->id);

        return $content;
    }

    protected function renderValue($rowId, $value, $currentCell, $currentRow, $header = false)
    {
        $content = '';

        if ($this->hasFilter($rowId, $header)) {
            $filters = $this->getFilters($rowId, $header);

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

    /**
     * @throws HeaderDoesNoMatchDataColumnCount
     * @throws HeaderNotSetException
     */
    protected function checkConfiguration()
    {
        if (!count($this->header)) {
            throw new HeaderNotSetException('The header is not set');
        }

        if (count($this->data) && count($this->data[0]) != count($this->header)) {
            throw new HeaderDoesNoMatchDataColumnCount('The header column count and body column count differ.');
        }
    }
}