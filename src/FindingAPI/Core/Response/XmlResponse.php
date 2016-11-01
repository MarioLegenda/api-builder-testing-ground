<?php

namespace FindingAPI\Core\Response;

use FindingAPI\Core\ResponseParser\ResponseItem\AspectHistogramContainer;
use FindingAPI\Core\ResponseParser\ResponseItem\CategoryHistogramContainer;
use FindingAPI\Core\ResponseParser\ResponseItem\ConditionHistogramContainer;
use FindingAPI\Core\ResponseParser\ResponseItem\ErrorContainer;
use FindingAPI\Core\ResponseParser\ResponseItem\PaginationOutput;
use FindingAPI\Core\ResponseParser\ResponseItem\RootItem;
use FindingAPI\Core\ResponseParser\ResponseItem\SearchResultsContainer;
use GuzzleHttp\Psr7\Response as GuzzleResponse;

class XmlResponse implements ResponseInterface
{
    /**
     * @var string $xmlString
     */
    private $xmlString;
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
        'errorContainer' => null,
        'paginationOutput' => null,
        'categoryHistogram' => null,
    );
    /**
     * @var GuzzleResponse
     */
    private $guzzleResponse;
    /**
     * Response constructor.
     * @param GuzzleResponse $guzzleResponse
     * @param string $xmlString
     */
    public function __construct(string $xmlString, GuzzleResponse $guzzleResponse = null)
    {
        $this->xmlString = $xmlString;
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
        $this->lazyLoadSimpleXml($this->xmlString);

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
    public function getAspectHistogramContainer($default = null)
    {
        $this->lazyLoadSimpleXml($this->xmlString);

        if ($this->responseItems['aspectHistogram'] instanceof AspectHistogramContainer) {
            return $this->responseItems['aspectHistogram'];
        }

        if (!empty($this->simpleXmlBase->aspectHistogramContainer)) {
            $this->responseItems['aspectHistogram'] = new AspectHistogramContainer($this->simpleXmlBase->aspectHistogramContainer);
        }

        if (!$this->responseItems['aspectHistogram'] instanceof AspectHistogramContainer and $default !== null) {
            return $default;
        }

        return $this->responseItems['aspectHistogram'];
    }
    /**
     * @return SearchResultsContainer
     */
    public function getSearchResults($default = null)
    {
        $this->lazyLoadSimpleXml($this->xmlString);

        if ($this->responseItems['searchResult'] instanceof SearchResultsContainer) {
            return $this->responseItems['searchResult'];
        }

        if (!empty($this->simpleXmlBase->searchResult)) {
            $this->responseItems['searchResult'] = new SearchResultsContainer($this->simpleXmlBase->searchResult);
        }

        if ($this->responseItems['searchResult'] === null and $default !== null) {
            return $default;
        }

        return $this->responseItems['searchResult'];
    }
    /**
     * @param null $default
     * @return mixed
     */
    public function getConditionHistogramContainer($default = null)
    {
        $this->lazyLoadSimpleXml($this->xmlString);

        if ($this->responseItems['conditionHistogramContainer'] instanceof ConditionHistogramContainer) {
            return $this->responseItems['conditionHistogramContainer'];
        }

        if (!empty($this->simpleXmlBase->conditionHistogramContainer)) {
            $this->responseItems['conditionHistogramContainer'] = new ConditionHistogramContainer($this->simpleXmlBase->conditionHistogramContainer);
        }

        if (!$this->responseItems['conditionHistogramContainer'] instanceof ConditionHistogramContainer and $default !== null) {
            return $default;
        }

        return $this->responseItems['conditionHistogramContainer'];
    }
    /**
     * @param null $default
     * @return mixed|null
     */
    public function getPaginationOutput($default = null)
    {
        $this->lazyLoadSimpleXml($this->xmlString);

        if ($this->responseItems['paginationOutput'] instanceof PaginationOutput) {
            return $this->responseItems['paginationOutput'];
        }

        if (!empty($this->simpleXmlBase->paginationOutput)) {
            $this->responseItems['paginationOutput'] = new PaginationOutput($this->simpleXmlBase->paginationOutput);
        }

        if (!$this->responseItems['paginationOutput'] instanceof PaginationOutput and $default !== null) {
            return $default;
        }

        return $this->responseItems['paginationOutput'];
    }
    /**
     * @param null $default
     * @return mixed|null
     */
    public function getCategoryHistogramContainer($default = null)
    {
        $this->lazyLoadSimpleXml($this->xmlString);

        if ($this->responseItems['categoryHistogram'] instanceof CategoryHistogramContainer) {
            return $this->responseItems['categoryHistogram'];
        }

        if (!empty($this->simpleXmlBase->categoryHistogramContainer)) {
            $this->responseItems['categoryHistogram'] = new CategoryHistogramContainer($this->simpleXmlBase->categoryHistogramContainer);
        }

        if (!$this->responseItems['categoryHistogram'] instanceof CategoryHistogramContainer and $default !== null) {
            return $default;
        }

        return $this->responseItems['categoryHistogram'];
    }
    /**
     * @param null $default
     * @return mixed|null
     */
    public function getErrors($default = null)
    {
        $this->lazyLoadSimpleXml($this->xmlString);

        if ($this->responseItems['errorContainer'] instanceof ErrorContainer) {
            return $this->responseItems['errorContainer'];
        }

        if (!empty($this->simpleXmlBase->errorMessage)) {
            $this->responseItems['errorContainer'] = new ErrorContainer($this->simpleXmlBase->errorMessage);
        }

        if (!$this->responseItems['errorContainer'] instanceof ErrorContainer and $default !== null) {
            return $default;
        }

        return $this->responseItems['errorContainer'];
    }
    /**
     * @return bool
     */
    public function isErrorResponse() : bool
    {
        $this->lazyLoadSimpleXml($this->xmlString);

        return $this->getRoot()->getAck() === 'Failure';
    }

    private function lazyLoadSimpleXml($xmlString)
    {
        if ($this->simpleXmlBase instanceof \SimpleXMLElement) {
            return;
        }

        $this->simpleXmlBase = simplexml_load_string($xmlString);

        $this->xmlString = null;
    }
}