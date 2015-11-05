<?php
namespace fhu\TableData\Filters;

use fhu\TableData\Filters\Struct\CallbackInfo;

class CheckAll implements FilterInterface
{
    /**
     * @param string $value
     * @param CallbackInfo $info
     * @return string
     */
    function apply($value, CallbackInfo $info)
    {
        $userData = $info->userData;

        if (isset($userData['id'])) {
            $id = $userData['id'];
        } else {
            $id = 'check_all';
        }

        if (isset($userData['name'])) {
            $name = $userData['name'];
        } else {
            $name = 'check_all';
        }

        if (isset($userData['class'])) {
            $class = $userData['class'];
        } else {
            $class = 'class';
        }

        if ($value) {
            $checked = 'checked="checked"';
        } else {
            $checked = '';
        }

        $function = 'checkUncheckAll_' . $id;

        $content = '';
        $content .= '<script>
function ' . $function . '(obj) {
    var container = obj;
    var tries = 0;

    while ((container = container.parentElement).tagName.toLowerCase() != "table") {
        if (tries++ > 15) {
            alert("Table element not found. The checkbox must be inside an html table.");
            break;
        }
    }

    if (typeof container !== "undefined") {
        var parentCheck = document.getElementById("' . $id . '");
        var inputs = container.getElementsByTagName("input");

        if (typeof parentCheck !== "undefined") {
            var newState = parentCheck.checked;
            for (var i = 0; i < inputs.length; i++) {
                if (inputs[i].type == "checkbox") {
                    inputs[i].checked = newState;
                }
            }
        } else {
            alert("Parent checkbox not found");
        }
    } else {
        alert("Container not found");
    }
}
</script>';

        $content .= '<input type="checkbox" ' . $checked . ' class="' . $class . '" id="' . $id . '" name="' . $name . '" value="check_all" onclick="' . $function . '(this)">';

        return $content;
    }
}