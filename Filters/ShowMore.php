<?php
namespace fhu\TableData\Filters;

use fhu\TableData\Filters\Struct\CallbackInfo;

class ShowMore implements FilterInterface
{
    /**
     * @var string
     */
    protected $url;

    /**
     * @var int
     */
    protected $idIndex = 0;

    /**
     * @param string $value
     * @param CallbackInfo $info
     * @return string
     */
    function apply($value, CallbackInfo $info)
    {
        $onclick = '';
        $href = '';
        if ($this->getUrl($info)) {
            $onclick = ' onclick="location.href=\'' . $this->getUrl($info) . '\'"';
            $href = $this->getUrl($info);
        }

        $content = '
                    <a href="' . $href . '">
                        ' . $value . '
                        <div style="float:right; cursor:pointer;" class="glyphicon glyphicon-zoom-in"' . $onclick . ' />
                        </div>
                    </a>
';

        return $content;
    }

    /**
     * @param CallbackInfo $info
     * @return string
     */
    public function getUrl(CallbackInfo $info = null)
    {
        $url = $this->url;

        if ($info) {
            $url = str_replace('#ID#', urlencode($info->rowValues[$this->getIdIndex()]), $url);
        }

        return $url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return int
     */
    public function getIdIndex()
    {
        return $this->idIndex;
    }

    /**
     * @param int $idIndex
     */
    public function setIdIndex($idIndex)
    {
        $this->idIndex = $idIndex;
    }
}