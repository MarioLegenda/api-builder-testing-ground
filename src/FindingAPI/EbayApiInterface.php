<?php

namespace FindingAPI;

use FindingAPI\Core\Request\Request;
use FindingAPI\Core\Response\ResponseInterface;

interface EbayApiInterface
{
    /**
     * @param string $inlineResponse
     * @return ResponseInterface
     */
    public function getResponse(string $inlineResponse = null) : ResponseInterface;
    /**
     * @return EbayApiInterface
     */
    public function send() : EbayApiInterface;
    /**
     * @return mixed
     */
    public function getProcessed();
    /**
     * @return Request
     */
    public function getRequest() : Request;
}