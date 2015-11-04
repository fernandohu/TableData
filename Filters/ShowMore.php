<?php
namespace fhu\TableData\Filters;

class ShowMore implements FilterInterface
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
        $onclick = '';
        $href = '';
        if (isset($userData['link'])) {
            $onclick = ' onclick="location.href=\'' . $userData['link'] . '\'"';
            $href = $userData['link'];
        }

        $content = '<div style="float:right; cursor:pointer;" class="glyphicon glyphicon-zoom-in"' . $onclick . '></div><a href="' . $href . '">' . $value . '</a>';

        return $content;
    }
}