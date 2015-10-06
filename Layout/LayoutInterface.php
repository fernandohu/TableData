<?php
namespace fhu\TableData\Layout;

interface LayoutInterface
{
    function beforeTable();
    function afterTable();

    function beforeHeader();
    function afterHeader();

    function beforeTableBody();
    function afterTableBody();

    /**
     * @param int $columnIndex
     * @param bool|null $order True for ASC, False for DESC and Null for NONE
     * @param string $width
     * @param string $link
     * @return string
     */
    function beforeHeaderCell($columnIndex, $order, $width, $link = '');

    /**
     * @param int $columnIndex
     * @param bool|null $order True for ASC, False for DESC and Null for NONE
     * @param string $width
     * @param string $link
     * @return string
     */
    function afterHeaderCell($columnIndex, $order, $width, $link = '');

    /**
     * @param int $rowIndex
     * @return mixed
     * @return string
     */
    function beforeRow($rowIndex);

    /**
     * @param int $rowIndex
     * @return mixed
     * @return string
     */
    function afterRow($rowIndex);

    /**
     * @param int $rowIndex
     * @param int $columnIndex
     * @param string $width
     * @return string
     */
    function beforeRowCell($rowIndex, $columnIndex, $width);

    /**
     * @param int $rowIndex
     * @param int $columnIndex
     * @param string $width
     * @return string
     */
    function afterRowCell($rowIndex, $columnIndex, $width);
}