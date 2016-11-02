<?php

namespace FindingAPI\Core\Response;

class FakeGuzzleResponse
{
    /**
     * @var string $responseBody
     */
    private $responseBody;
    /**
     * FakeGuzzleResponse constructor.
     * @param string $responseBody
     */
    public function __construct(string $responseBody)
    {
        $this->responseBody = $responseBody;
    }

    /**
     * @return string
     */
    public function getBody() : string 
    {
        return $this->responseBody;
    }
}