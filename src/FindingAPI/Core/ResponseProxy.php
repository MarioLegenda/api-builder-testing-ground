<?php

namespace FindingAPI\Core;

use GuzzleHttp\Psr7\Response as GuzzleResponse;

class ResponseProxy
{
    /**
     * @var GuzzleResponse $guzzleResponse
     */
    private $guzzleResponse;
    /**
     * ResponseProxy constructor.
     * @param $responseToParse
     * @param GuzzleResponse $guzzleResponse
     * @param string $responseDataFormat
     */
    public function __construct($responseToParse, GuzzleResponse $guzzleResponse, string $responseDataFormat)
    {
        
    }
}