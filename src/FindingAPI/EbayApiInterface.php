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
     * @param Request $request
     * @return EbayApiInterface
     */
    public function send() : EbayApiInterface;
    /**
     * @return mixed
     */
    public function getProcessedRequestString();
    /**
     * @return Request
     */
    public function getRequest() : Request;
    /**
     * @param string $operationName
     * @return Request
     */
    public function createMethodCall(string $operationName) : Request;
}