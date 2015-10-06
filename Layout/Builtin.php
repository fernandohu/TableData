<?php
namespace fhu\TableData\Layout;

use fhu\TableData\Table;

class Builtin implements LayoutInterface
{
    /**
     * @return string
     */
    function beforeTable()
    {
        $content = '<table class="table">';
        return $content;
    }

    /**
     * @return string
     */
    function afterTable()
    {
        $content = '</table>';
        return $content;
    }

    /**
     * @return string
     */
    function beforeHeader()
    {
        $content = '<thead><tr class="header_row">';
        return $content;
    }

    /**
     * @return string
     */
    function afterHeader()
    {
        $content = '</tr></thead>';
        return $content;
    }

    /**
     * @return string
     */
    function beforeTableBody()
    {
        $content = '<tbody>';
        return $content;
    }

    /**
     * @return string
     */
    function afterTableBody()
    {
        $content = '</tbody>';
        return $content;
    }

    /**
     * @param int $columnIndex
     * @param bool|null $order True for ASC, False for DESC and Null for NONE
     * @param string $width
     * @param string $link
     * @return string
     */
    function beforeHeaderCell($columnIndex, $order, $width, $link = '')
    {
        $content = '<th class="header_cell" width="' . $width . '">';

        if (!is_null($link)) {
            $content .= '<a href="' . $link . '">';
        }

        return $content;
    }

    /**
     * @param int $columnIndex
     * @param bool|null $order True for ASC, False for DESC and Null for NONE
     * @param string $width
     * @param string $link
     * @return string
     */
    function afterHeaderCell($columnIndex, $order, $width, $link = '')
    {
        $content = '';

        switch ($order)
        {
            case Table::DIRECTION_DOWN:
                $content .= '&#x25BC;';
                break;
            case Table::DIRECTION_UP:
                $content .= '&#x25B2;';
                break;
        }

        if (!empty($link)) {
            $content .= '</a>';
        }

        $content .= '</th>';
        return $content;
    }

    /**
     * @param int $rowIndex
     * @return mixed
     * @return string
     */
    function beforeRow($rowIndex)
    {
        $content = '<tr class="body_row">';
        return $content;
    }

    /**
     * @param int $rowIndex
     * @return mixed
     * @return string
     */
    function afterRow($rowIndex)
    {
        $content = '</tr>';
        return $content;
    }

    /**
     * @param int $rowIndex
     * @param int $columnIndex
     * @param string $width
     * @return string
     */
    function beforeRowCell($rowIndex, $columnIndex, $width)
    {
        $content = '<td class="body_cell" width="' . $width . '">';
        return $content;
    }

    /**
     * @param int $rowIndex
     * @param int $columnIndex
     * @param string $width
     * @return string
     */
    function afterRowCell($rowIndex, $columnIndex, $width)
    {
        $content = '</td>';
        return $content;
    }

}