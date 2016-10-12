<?php

namespace FindingAPI\Core;

use FindingAPI\Core\ResponseParser\ResponseItem\AspectHistogramContainer;
use FindingAPI\Core\ResponseParser\ResponseItem\ResponseItemInterface;
use FindingAPI\Core\ResponseParser\ResponseItem\RootItem;
use FindingAPI\Core\ResponseParser\ResponseItem\SearchResultsContainer;
use GuzzleHttp\Psr7\Response as GuzzleResponse;

class Response
{
    /**
     * @var \SimpleXMLElement $simpleXmlBase
     */
    private $simpleXmlBase;
    /**
     * @var array $responseItems
     */
    private $responseItems = array(
        'rootItem' => null,
        'aspectHistogram' => null,
    );
    /**
     * @var GuzzleResponse
     */
    private $guzzleResponse;
    /**
     * Response constructor.
     * @param GuzzleResponse $guzzleResponse
     * @param \SimpleXmlElement $simpleXMLBase
     */
    public function __construct(\SimpleXMLElement $simpleXMLBase, GuzzleResponse $guzzleResponse)
    {
        $this->simpleXmlBase = $simpleXMLBase;
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
     * @return RootItem
     */
    public function getRoot() : RootItem
    {
        return $this->createRootItem();
    }
    /**
     * @return null|AspectHistogramContainer
     */
    public function getAspectFilters()
    {
        return $this->responseItems['aspectHistogram'];
    }

    private function createRootItem() : RootItem
    {
        if ($this->responseItems['rootItem'] instanceof RootItem) {
            return $this->responseItems['rootItem'];
        }

        $this->responseItems['rootItem'] = new RootItem($this->simpleXmlBase);

        return $this->responseItems['rootItem'];
    }
}