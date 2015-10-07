<?php

$content .= '
<script>
    function selectLine_' . $id . '(obj)
    {
        var node = obj;
        var count = 0;
        while (node.parentNode.tagName.toLowerCase() != \'tr\') {
            node = node.parentNode;
            if (count++ > 5) {
                alert(\'Error: Could not find line node.\');
                return;
            }
        }

        node = node.parentNode;
        var inputs = node.getElementsByTagName(\'input\');

        if (inputs.length == 0) {
            alert(\'Error: Could not find checkbox.\');
        }

        inputs[0].checked = !inputs[0].checked;

    }
</script>
';