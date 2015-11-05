<?php
namespace fhu\TableData\Filters;

use fhu\TableData\Filters\Struct\CallbackInfo;

interface FilterInterface
{
    /**
     * @param string $value
     * @param CallbackInfo $info
     * @return string
     */
    function apply($value, CallbackInfo $info);
}