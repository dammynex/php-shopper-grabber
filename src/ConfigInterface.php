<?php

namespace Brainex\ShopperGrabber;

use Brainex\ShopperGrabber\Query;

interface ConfigInterface
{
    public function getHost() : string;

    public function getImageQuery() : Query;

    public function getPriceQuery() : Query;

    public function getTitleQuery() : Query;

    public function onResultReceived() : ?array;
}