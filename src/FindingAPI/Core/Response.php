<?php

namespace FindingAPI\Core;

use GuzzleHttp\Psr7\Response as GuzzleResponse;

class Response
{
    /**
     * @var GuzzleResponse
     */
    private $guzzleResponse;
    /**
     * Response constructor.
     * @param GuzzleResponse $guzzleResponse
     */
    public function __construct(GuzzleResponse $guzzleResponse)
    {
        $this->guzzleResponse = $guzzleResponse;
    }
    /**
     * @return GuzzleResponse
     */
    public function getGuzzleResponse() : GuzzleResponse
    {
        return $this->guzzleResponse;
    }
    /**
     * @return string
     */
    public function getResponseType() : string
    {

    }
}