<?php
namespace fhu\TableData\Layout;

use fhu\TableData\Params\Body,
    fhu\TableData\Params\Header,
    fhu\TableData\Params\HeaderCell,
    fhu\TableData\Params\Row,
    fhu\TableData\Params\RowCell,
    fhu\TableData\Table,
    fhu\TableData\Params\Table as TableParam;

class Builtin extends LayoutAbstract
{
    public static $renderLineCounter = 0;

    /**
     * @param TableParam $params
     * @return string
     */
    function beforeTable(TableParam $params)
    {
        $content = '';

        $id = $this->config->getId();
        require(__DIR__ . '/../javascript/selectline.php');

        $content .= '<table class="table table-hover" id="' . $id . '">';
        return $content;
    }

    /**
     * @param TableParam $params
     * @return string
     */
    function afterTable(TableParam $params)
    {
        $content = '</table>';
        return $content;
    }

    /**
     * @param Header $params
     * @return string
     */
    function beforeHeader(Header $params)
    {
        $content = '<thead><tr class="header_row">';
        return $content;
    }

    /**
     * @param Header $params
     * @return string
     */
    function afterHeader(Header $params)
    {
        $content = '</tr></thead>';
        return $content;
    }

    /**
     * @param Body $params
     * @return string
     */
    function beforeTableBody(Body $params)
    {
        $content = '<tbody>';
        return $content;
    }

    /**
     * @param Body $params
     * @return string
     */
    function afterTableBody(Body $params)
    {
        $content = '</tbody>';
        return $content;
    }

    /**
     * @param HeaderCell $params
     * @return string
     */
    function beforeHeaderCell(HeaderCell $params)
    {
        $content = '<th class="header_cell" width="' . $params->width . '">';

        if (!is_null($params->link)) {
            $content .= '<a href="' . $params->link . '">';
        }

        return $content;
    }

    /**
     * @param HeaderCell $params
     * @return string
     */
    function afterHeaderCell(HeaderCell $params)
    {
        $content = '';

        switch ($params->order)
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
     * @param Row $params
     * @return string
     */
    function beforeRow(Row $params)
    {
        self::$renderLineCounter++;

        $content = '<tr class="body_row">';
        return $content;
    }

    /**
     * @param Row $params
     * @return string
     */
    function afterRow(Row $params)
    {
        $content = '</tr>';
        return $content;
    }

    /**
     * @param RowCell $params
     * @return string
     */
    function beforeRowCell(RowCell $params)
    {
        $content = '<td class="body_cell" width="' . $params->width . '" onclick="selectLine_' . $this->config->getId() . '(this);">';
        return $content;
    }

    /**
     * @param RowCell $params
     * @return string
     */
    function afterRowCell(RowCell $params)
    {
        $content = '</td>';
        return $content;
    }

}