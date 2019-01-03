<?php

namespace Brainex\ShopperGrabber;

class Query
{
    /**
     * XPath Query
     *
     * @var string
     */
    private $_xpath_query = '';

    /**
     * Attribute
     *
     * @var string
     */
    private $_attribute = null;

    /**
     * Element index
     *
     * @var integer
     */
    private $_index = 0;

    /**
     * Query class constructor
     *
     * @param string $query Xpath query
     * @param string $attribute Element attribute
     * @param int $index Element index
     */
    public function __construct(string $query, ?string $attribute = null, int $index = 0)
    {
        $this->_xpath_query = $query;
        $this->_attribute = $attribute;
        $this->_index = $index;
    }

    /**
     * Get attribute
     *
     * @return string|null
     */
    public function getAttribute() : ?string
    {
        return $this->_attribute;
    }

    /**
     * Element index
     *
     * @return integer
     */
    public function getIndex() : int
    {
        return $this->_index;
    }

    /**
     * Get xpath query
     *
     * @return string
     */
    public function getQuery() : string
    {
        return $this->_xpath_query;
    }
}