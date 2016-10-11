<?php

namespace FindingAPI\Core;

use FindingAPI\Core\ResponseParser\ResponseItem\AspectHistogramContainer;
use FindingAPI\Core\ResponseParser\ResponseItem\ResponseItemInterface;
use FindingAPI\Core\ResponseParser\ResponseItem\RootItem;
use GuzzleHttp\Psr7\Response as GuzzleResponse;

class Response
{
    /**
     * @var array $responseItems
     */
    private $responseItems;
    /**
     * @var GuzzleResponse
     */
    private $guzzleResponse;
    /**
     * Response constructor.
     * @param GuzzleResponse $guzzleResponse
     * @param array $responseItems
     */
    public function __construct(GuzzleResponse $guzzleResponse, array $responseItems)
    {
        $this->guzzleResponse = $guzzleResponse;
        $this->responseItems = $responseItems;
    }
    /**
     * @return GuzzleResponse
     */
    public function getGuzzleResponse() : GuzzleResponse
    {
        return $this->guzzleResponse;
    }
    /**
     * @return RootItem
     */
    public function getRoot() : RootItem
    {
        return $this->responseItems['rootItem'];
    }

    /**
     * @return null|AspectHistogramContainer
     */
    public function getAspectFilters()
    {
        return $this->responseItems['aspectHistogram'];
    }
}