<?php

namespace SDKBuilder\SDK;

use SDKBuilder\Request\AbstractRequest;

interface SDKInterface
{
    /**
     * @return void
     */
    public function send() : SDKInterface;
    /**
     * @return AbstractRequest
     */
    public function getRequest() : AbstractRequest;
}