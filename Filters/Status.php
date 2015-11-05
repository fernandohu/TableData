<?php
namespace fhu\TableData\Filters;

use fhu\TableData\Filters\Struct\CallbackInfo;

class Status implements FilterInterface
{
    /**
     * @param string $value
     * @param CallbackInfo $info
     * @return string
     */
    function apply($value, CallbackInfo $info)
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