<?php

namespace Brainex\ShopperGrabber;

class ShopperGrabber
{
    static $_configurations = [];

    /**
     * Class constructor
     *
     * @param ConfigInterface $config Configuration
     */
    public function __construct(?array $configurations = null)
    {

        if(!$configurations) {
            return;
        }

        foreach($configurations as $config) {
            $this->setConfig($config);
        }
    }

    /**
     * Get grabber result
     *
     * @param Url $url
     * @return ResultHandler
     */
    public function getResult(Url $url) : ResultHandler
    {
        $config = $this->getConfigFromUrl($url->host);
        return new ResultHandler($config, $url);
    }

    /**
     * Set config
     *
     * @param ConfigInterface $config
     * @return self
     */
    public function setConfig(ConfigInterface $config) : self
    {
        self::$_configurations[$config->getHost()] = $config;
        return $this;
    }

    /**
     * Get the configuration to use from the provided url
     *
     * @param string $url Url to retrieve configuration
     * @return ConfigInterface|null
     */
    private function getConfigFromUrl(string $host) : ?ConfigInterface
    {
        return self::$_configurations[$host] ?? null;
    }
}