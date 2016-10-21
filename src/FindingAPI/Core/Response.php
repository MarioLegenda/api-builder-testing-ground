<?php

namespace FindingAPI\Core;

use FindingAPI\Core\ResponseParser\ResponseItem\AspectHistogramContainer;
use FindingAPI\Core\ResponseParser\ResponseItem\ConditionHistogramContainer;
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
        'searchResult' => null,
        'conditionHistogramContainer' => null,
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
        if ($this->responseItems['rootItem'] instanceof RootItem) {
            return $this->responseItems['rootItem'];
        }

        $this->responseItems['rootItem'] = new RootItem($this->simpleXmlBase);

        return $this->responseItems['rootItem'];
    }
    /**
     * @param mixed $default
     * @return null|AspectHistogramContainer
     */
    public function getAspectFilters($default = null)
    {
        if ($this->responseItems['aspectHistogram'] instanceof AspectHistogramContainer) {
            return $this->responseItems['aspectHistogram'];
        }

        if (!$this->responseItems['aspectHistogram'] instanceof AspectHistogramContainer and $default !== null) {
            return $default;
        }

        $this->responseItems['aspectHistogram'] = new AspectHistogramContainer($this->simpleXmlBase->aspectHistogramContainer);

        return $this->responseItems['aspectHistogram'];
    }
    /**
     * @return SearchResultsContainer
     */
    public function getSearchResults() : SearchResultsContainer
    {
        if ($this->responseItems['searchResult'] instanceof SearchResultsContainer) {
            return $this->responseItems['searchResult'];
        }

        $this->responseItems['searchResult'] = new SearchResultsContainer($this->simpleXmlBase->searchResult);

        return $this->responseItems['searchResult'];
    }
    /**
     * @param null $default
     * @return mixed
     */
    public function getConditionHistogramContainer($default = null)
    {
        if ($this->responseItems['conditionHistogramContainer'] instanceof ConditionHistogramContainer) {
            return $this->responseItems['conditionHistogramContainer'];
        }

        if (!$this->responseItems['conditionHistogramContainer'] instanceof ConditionHistogramContainer) {
            return null;
        }

        if (!$this->responseItems['conditionHistogramContainer'] instanceof ConditionHistogramContainer and $default !== null) {
            return $default;
        }

        $this->responseItems['conditionHistogramContainer'] = new ConditionHistogramContainer($this->simpleXmlBase->conditionHistogramContainer);

        return $this->responseItems['conditionHistogramContainer'];
    }
}