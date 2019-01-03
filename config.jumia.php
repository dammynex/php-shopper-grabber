<?php

use Brainex\ShopperGrabber\Query;
use Brainex\ShopperGrabber\ConfigInterface;

/**
 * Jumia configuration for shopper grabber
 * 
 * @author Damilola Ezekiel <damilolaofficial@gmail.com>
 */
class JumiaConfig implements ConfigInterface
{
    /**
     * Base url
     *
     * @var string
     */
    private $_base_url = 'https://www.jumia.com.ng/';

    /**
     * Host name
     *
     * @var string
     */
    private $_host = '';

    /**
     * Image query
     *
     * @return Query
     */
    public function getImageQuery(): Query
    {
        return new Query('//img[@id="productImage"]', 'data-src');
    }

    /**
     * Price query
     *
     * @return Query
     */
    public function getPriceQuery(): Query
    {
        return new Query('//div[@class="price-box"]//span[@data-price]', 'data-price');
    }

    /**
     * Title query
     *
     * @return Query
     */
    public function getTitleQuery() : Query
    {
        return new Query('//h1[@class="title"]');
    }

    /**
     * Get host
     *
     * @return string
     */
    public function getHost(): string
    {

        if($this->_host) {
            return $this->_host;
        }

        $data = parse_url($this->_base_url);
        $this->_host = $data['host'] ?? null;

        return $this->_host;
    }

    /**
     * Do some functions when result is received
     *
     * @return array|null
     */
    public function onResultReceived(): ?array
    {
        return array(
            'subimages' => function(DOMDocument $doc) {

                $data = [];
                $xpath = new DOMXPath($doc);
                $results = $xpath->query('//div[@id="thumbs-slide"]//a');

                foreach($results as $res) {
                    $data[] = $res->firstChild->getAttribute('data-src');
                }

                return $data;
            }
        );
    }
}