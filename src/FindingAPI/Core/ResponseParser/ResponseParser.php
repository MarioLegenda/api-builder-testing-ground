<?php

namespace FindingAPI\Core\ResponseParser;

use FindingAPI\Core\Response;
use GuzzleHttp\Psr7\Response as GuzzleResponse;

class ResponseParser
{
    /**
     * @var GuzzleResponse
     */
    private $guzzleResponse;
    /**
     * @var \SimpleXMLElement
     */
    private $simpleXml;
    /**
     * ResponseParser constructor.
     * @param string $xmlString
     * @param GuzzleResponse $guzzleResponse
     */
    public function __construct(string $xmlString, GuzzleResponse $guzzleResponse)
    {
        $this->simpleXml = simplexml_load_string($xmlString);
        $this->guzzleResponse = $guzzleResponse;
    }
    /**
     * @return ResponseParser
     */
    public function parse() : ResponseParser
    {
        return $this;
    }
    /**
     * @return ResponseParser
     */
    public function createResponse() : ResponseParser
    {
        return $this;
    }
    /**
     * @return Response
     */
    public function getResponse() : Response
    {
        return new Response($this->guzzleResponse);
    }
}