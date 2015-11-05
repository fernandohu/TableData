<?php
namespace fhu\TableData\Filters;

use fhu\TableData\Filters\Struct\CallbackInfo;

class Check implements FilterInterface
{
    /**
     * @param string $value
     * @param CallbackInfo $info
     * @return string
     */
    function apply($value, CallbackInfo $info)
    {
        if (isset($userData['id'])) {
            $id = $userData['id'];
        } else {
            $id = 'entry';
        }

        if (isset($userData['useCellIndex'])) {
            $id .= $info->cellIndex;
        }

        if (isset($userData['useRowIndex'])) {
            $id .= $info->rowIndex;
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