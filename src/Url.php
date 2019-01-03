<?php

namespace Brainex\ShopperGrabber;

class Url
{
    private $_url = '';

    public $host = '';
    public $path = '';
    public $query = [];
    public $scheme = '';

    /**
     * Url constructor
     *
     * @param string $url
     */
    public function __construct(string $url)
    {
        $this->_url = $url;
        $this->parse();
    }

    public function __toString()
    {
        return $this->_url;
    }

    /**
     * Parse url data
     *
     * @return void
     */
    private function parse()
    {
        $data = parse_url($this->_url);

        $this->scheme = $data['scheme'] ?: 'http';
        $this->host = $data['host'] ?: '';
        $this->path = $data['path'] ?: '';
        $this->query = $this->parseQuery($data['query'] ?: '');
    }

    /**
     * Parse query
     *
     * @param string $query
     * @return array
     */
    public function parseQuery(string $query) : array
    {

        $data = [];

        if(!$query) {
            return $data;
        }

        $params = explode('&', $query);

        foreach($params as $parameter) {
            $parameter_vars = explode('=', $parameter);
            $data[$parameter_vars[0]] = $parameter_vars[1] ?: null;
        }

        return $data;
    }
}