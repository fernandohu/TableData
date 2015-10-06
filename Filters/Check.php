<?php
namespace fhu\TableData\Filters;

class Check implements FilterInterface
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
        if (isset($userData['id'])) {
            $id = $userData['id'];
        } else {
            $id = 'entry';
        }

        if (isset($userData['useCellIndex'])) {
            $id .= $currentCell;
        }

        if (isset($userData['useRowIndex'])) {
            $id .= $currentRow;
        }

        if (isset($userData['name'])) {
            $name = $userData['name'];
        } else {
            $name = 'entry';
        }

        if (isset($userData['class'])) {
            $class = $userData['class'];
        } else {
            $class = 'class';
        }

        return '<input type="checkbox" class="' . $class . '" id="' . $id . '" name="' . $name . '" value="' . htmlspecialchars($value) . '">';
    }
}