<?php
namespace fhu\TableData;

use fhu\TableData\Exception\EmptyHeadersException,
    fhu\TableData\Exception\InvalidHeadersException,
    fhu\TableData\Exception\LinkParameterNotSetException;
use fhu\TableData\Layout\LayoutInterface;
use fhu\TableData\Layout\LayoutManager;
use fhu\TableData\Model\Config;

class Table
{
    /**
     * Direction constants
     */
    const DIRECTION_UP = 'desc';
    const DIRECTION_DOWN = 'asc';
    const DIRECTION_NONE = 'none';

    /**
     * @var Config
     */
    protected $config;

    /**
     * @var LayoutManager
     */
    protected $layoutManager;

    /**
     * @param LayoutInterface $layout
     */
    public function __construct($layout)
    {
        $this->layout        = $layout;
        $this->config        = new Config();
        $this->layoutManager = new LayoutManager($this->config, $layout);
    }

    public function render()
    {
        return $this->layoutManager->render();
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
        $this->config->setHeader($cells);
    }

    /**
     * @param string $rowId
     * @param string $direction
     * @return mixed|string
     */
    public function getHeaderLink($rowId = '', $direction = self::DIRECTION_DOWN)
    {
        return $this->config->getHeaderLink($rowId, $direction);
    }

    public function getNextDirection($direction)
    {
        $this->config->getNextDirection($direction);
    }

    /**
     * @param $link
     * @throws LinkParameterNotSetException
     */
    public function setHeaderLink($link)
    {
        $this->config->setHeaderLink($link);
    }

    /**
     * @return array
     */
    public function getColumnSizes()
    {
        return $this->config->getColumnSizes();
    }

    /**
     * Array of boolean values. True is ASC, false is DESC. Use null if you don't want to display
     * the order icon.
     *
     * @param array $sizes
     */
    public function setColumnSizes(array $sizes)
    {
        $this->config->setColumnSizes($sizes);
    }

    /**
     * Array of boolean values. Keys are ROW IDs, and values must be true or false.
     *
     * @param array
     */
    public function enableOrdering(array $ordering)
    {
        $this->config->enableOrdering($ordering);
    }

    /**
     * @return array
     */
    public function getEnabledOrdering()
    {
        return $this->config->getEnabledOrdering();
    }

    /**
     * Returns TRUE if ordering is enabled for the specified ROW ID.
     *
     * @param string $rowId
     * @return bool
     */
    public function showOrder($rowId)
    {
        return $this->config->showOrder($rowId);
    }

    /**
     * Sets the current ORDERING.
     *
     * @param string $order
     */
    public function setOrder($order = self::DIRECTION_DOWN)
    {
        $this->config->setOrder($order);
    }

    /**
     * Gets the current ORDERING.
     *
     * @return string
     */
    public function getOrder()
    {
        return $this->config->getOrder();
    }

    /**
     * Sets the columns that is being ordered.
     *
     * @param string $rowId
     */
    public function setOrderingColumn($rowId)
    {
        $this->config->setOrderingColumn($rowId);
    }

    /**
     * Gets the column that is being ordered.
     *
     * @return string
     */
    public function getOrderingColumn()
    {
        return $this->config->getOrderingColumn();
    }

    /**
     * @return array
     */
    public function getHeader()
    {
        return $this->config->getHeader();
    }

    /**
     * Multidimensional array with values representing cell values of the table body. Indexes are ignored, only
     * array values are used.
     *
     * @param array $data
     */
    public function setData(array $data)
    {
        $this->config->setData($data);
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->config->getData();
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
        $this->config->setFilter($rowId, $header, $callback, $data);
    }

    /**
     * @param string $rowId
     * @param bool $header
     * @return array
     */
    public function getFilters($rowId, $header = false)
    {
        return $this->config->getFilters($rowId, $header);
    }

    /**
     * @param string $rowId
     * @param bool $header
     * @return bool
     */
    public function hasFilter($rowId, $header = false)
    {
        return $this->config->hasFilter($rowId, $header);
    }

    /**
     * @param $headerIndex
     * @return string
     */
    public function getRowId($headerIndex)
    {
        return $this->config->getRowId($headerIndex);
    }

    /**
     * @param string $rowId
     * @return int
     */
    public function getColumnSize($rowId) {
        return $this->config->getColumnSize($rowId);
    }
}