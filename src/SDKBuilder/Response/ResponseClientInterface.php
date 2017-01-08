<?php

namespace SDKBuilder\Response;

interface ResponseClientInterface
{
    /**
     * @return null|string
     */
    public function getBody() : ?string;
}