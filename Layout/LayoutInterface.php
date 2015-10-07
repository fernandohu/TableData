<?php
namespace fhu\TableData\Layout;

use fhu\TableData\Params\Body;
use fhu\TableData\Params\Header;
use fhu\TableData\Params\HeaderCell;
use fhu\TableData\Params\Row;
use fhu\TableData\Params\RowCell;
use fhu\TableData\Params\Table;

interface LayoutInterface
{
    /**
     * @param Table $params
     * @return string
     */
    function beforeTable(Table $params);

    /**
     * @param Table $params
     * @return string
     */
    function afterTable(Table $params);

    /**
     * @param Header $params
     * @return string
     */
    function beforeHeader(Header $params);

    /**
     * @param Header $params
     * @return string
     */
    function afterHeader(Header $params);

    /**
     * @param Body $params
     * @return string
     */
    function beforeTableBody(Body $params);

    /**
     * @param Body $params
     * @return string
     */
    function afterTableBody(Body $params);

    /**
     * @param HeaderCell $params
     * @return string
     */
    function beforeHeaderCell(HeaderCell $params);

    /**
     * @param HeaderCell $params
     * @return string
     */
    function afterHeaderCell(HeaderCell $params);

    /**
     * @param Row $params
     * @return string
     */
    function beforeRow(Row $params);

    /**
     * @param Row $params
     * @return string
     */
    function afterRow(Row $params);

    /**
     * @param RowCell $params
     * @return string
     */
    function beforeRowCell(RowCell $params);

    /**
     * @param RowCell $params
     * @return string
     */
    function afterRowCell(RowCell $params);
}