<?php

namespace SDKBuilder\SDK;

interface SDKInterface
{
    /**
     * @return void
     */
    public function send() : SDKInterface;
}