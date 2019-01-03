<?php

namespace Brainex\ShopperGrabber;

use DOMXPath;
use DOMDocument;
use GuzzleHttp\Client;

class ResultHandler
{

    /**
     * Config
     *
     * @var ConfigInterface
     */
    private $_config;

    /**
     * Url
     *
     * @var Url
     */
    private $_url;

    /**
     * Url source code
     *
     * @var string
     */
    private $_source = '';

    /**
     * Url dom
     *
     * @var DOMDocument
     */
    private $_dom;

    /**
     * Grabber result handler
     *
     * @param ConfigInterface $config
     * @param Url $url
     */
    public function __construct(ConfigInterface $config, Url $url)
    {
        $this->_config = $config;
        $this->_url = $url;
        $this->fetchSource();
    }

    /**
     * Get a custom definition assigned is onResultReceived in the config
     *
     * @param string $name
     * @return mixed
     */
    public function getCustom(string $name)
    {
        $closure = $this->_config->onResultReceived()[$name] ?? null;

        if(!$closure) {
            return null;
        }

        if(!is_callable($closure)) {
            return null;
        }

        return $closure($this->getDom());
    }

    /**
     * Get source dom
     *
     * @return DOMDocument
     */
    public function getDom() : DOMDocument
    {
        if($this->_dom) {
            return $this->_dom;
        }

        $doc = new DOMDocument();
        @$doc->loadHTML($this->getSource());

        $this->_dom = $doc;

        return $this->_dom;
    }

    /**
     * Get source content
     *
     * @return string
     */
    public function getSource() : string
    {
        return $this->_source;
    }

    /**
     * Get image url
     *
     * @return string|null
     */
    public function getImageUrl() : ?string
    {
        return $this->parseQuery($this->_config->getImageQuery());
    }

    /**
     * Get price
     *
     * @return string|null
     */
    public function getPrice() : ?float
    {
        return (float) $this->parseQuery($this->_config->getPriceQuery());
    }

    /**
     * Get title
     *
     * @return string|null
     */
    public function getTitle() : ?string
    {
        return $this->parseQuery($this->_config->getTitleQuery());
    }

    /**
     * Use dom
     *
     * @param callable $callback
     * @return void
     */
    public function useDOM(callable $callback)
    {
        $callback($this->getDom());
    }

    /**
     * Fetch source
     *
     * @return string
     */
    private function fetchSource() : string
    {
        if($this->_source) {
            return $this->_source;
        }

        $client = new Client();
        $response = $client->get((string) $this->_url);

        $this->_source = $response->getBody()->getContents();
        return $this->_source;
    }

    /**
     * Query parser
     *
     * @param Query $query
     * @return ?string
     */
    private function parseQuery(Query $query)
    {
        $image_xpath = new DOMXPath($this->getDom());
        $elements = $image_xpath->query($query->getQuery());

        if(!count($elements)) {
            return null;
        }

        $element = $elements[$query->getIndex()];

        if($query->getAttribute()) {
            return $element->getAttribute($query->getAttribute());
        }

        return $element->nodeValue;
    }
}