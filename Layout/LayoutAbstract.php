<?php
namespace fhu\TableData\Layout;

use fhu\TableData\Model\Config;

abstract class LayoutAbstract implements LayoutInterface
{
    /**
     * @var Config
     */
    protected $config;

    /**
     * @return Config
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param Config $config
     */
    public function setConfig($config)
    {
        $this->config = $config;
    }
}