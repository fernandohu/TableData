<?php
namespace fhu\TableData\Filters;

class Status implements FilterInterface
{
    /**
     * @param string $value
     * @param int $currentCell
     * @param int $currentRow
     * @param mixed $userData
     * @return string
     */
    public function apply($value, $currentCell, $currentRow, $userData)
    {
        switch ($value) {
            case true:
            case 1:
                $color = 'green';
                break;

            case 0:
            case false:
                $color = 'red';
                break;
        }

        $content = '<div style="width:15px; height:15px; overflow:visible; background-color: ' . $color . '">&nbsp;</div>';

        return $content;
    }
}