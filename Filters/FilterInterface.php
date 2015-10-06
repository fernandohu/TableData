<?php
namespace fhu\TableData\Filters;

interface FilterInterface
{
    /**
     * @param string $value
     * @param int $currentCell
     * @param int $currentRow
     * @param mixed $userData
     * @return string
     */
    function apply($value, $currentCell, $currentRow, $userData);
}