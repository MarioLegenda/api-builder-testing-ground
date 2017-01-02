<?php

namespace FindingAPI\Core\Response;

use FindingAPI\Core\ResponseParser\ResponseItem\RootItem;
use GuzzleHttp\Psr7\Response as GuzzleResponse;

class JsonResponse implements ResponseInterface
{
    /**
     * @var GuzzleResponse $response
     */
    private $guzzleResponse;
    /**
     * @var array $jsonResponse
     */
    private $jsonResponse;
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
     * JsonResponse constructor.
     * @param ArrayConvertableInterface $xmlResponse
     * @param GuzzleResponse $response
     */
    public function __construct(ArrayConvertableInterface $xmlResponse, GuzzleResponse $response)
    {
        $this->jsonResponse = $xmlResponse->toArray();
        $this->guzzleResponse = $response;
    }

    /**
     * @return \FindingAPI\Core\ResponseParser\ResponseItem\RootItem
     */
    public function getRoot() : RootItem
    {
    }
    /**
     * @param null $default
     * @return \FindingAPI\Core\ResponseParser\ResponseItem\AspectHistogramContainer|null
     */
    public function getAspectHistogramContainer($default = null)
    {
    }
    /**
     * @param null $default
     * @return \FindingAPI\Core\ResponseParser\ResponseItem\SearchResultsContainer
     */
    public function getSearchResults($default = null)
    {
    }
    /**
     * @param null $default
     * @return mixed
     */
    public function getConditionHistogramContainer($default = null)
    {
    }
    /**
     * @param null $default
     * @return mixed|null
     */
    public function getPaginationOutput($default = null)
    {
    }
    /**
     * @param null $default
     * @return mixed|null
     */
    public function getCategoryHistogramContainer($default = null)
    {
    }
    /**
     * @param null $default
     * @return mixed|null
     */
    public function getErrors($default = null)
    {
    }
    /**
     * @return bool
     */
    public function isErrorResponse() : bool
    {
    }
    /**
     * @return string
     */
    public function getRawResponse(): string
    {
        return json_encode($this->jsonResponse);
    }
}