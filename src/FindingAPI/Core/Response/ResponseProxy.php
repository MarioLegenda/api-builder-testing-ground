<?php

namespace FindingAPI\Core\Response;

use FindingAPI\Core\ResponseParser\ResponseItem\RootItem;
use GuzzleHttp\Psr7\Response as GuzzleResponse;
use FindingAPI\Core\Response\ResponseInterface;

class ResponseProxy implements ResponseInterface
{
    /**
     * @var ResponseInterface $response
     */
    private $response;
    /**
     * ResponseProxy constructor.
     * @param $responseToParse
     * @param GuzzleResponse $guzzleResponse
     * @param string $responseDataFormat
     */
    public function __construct($responseToParse, GuzzleResponse $guzzleResponse = null, string $responseDataFormat)
    {
        switch ($responseDataFormat) {
            case 'xml':
                $this->response = new XmlResponse($responseToParse, $guzzleResponse);

                break;
            case 'json':
                $this->response = new JsonResponse($responseToParse, $guzzleResponse);
        }
    }
    /**
     * @return \FindingAPI\Core\ResponseParser\ResponseItem\RootItem
     */
    public function getRoot() : RootItem
    {
        return $this->response->getRoot();
    }
    /**
     * @param null $default
     * @return \FindingAPI\Core\ResponseParser\ResponseItem\AspectHistogramContainer|null
     */
    public function getAspectHistogramContainer($default = null)
    {
        return $this->response->getAspectHistogramContainer($default);
    }
    /**
     * @param null $default
     * @return \FindingAPI\Core\ResponseParser\ResponseItem\SearchResultsContainer
     */
    public function getSearchResults($default = null)
    {
        return $this->response->getSearchResults($default);
    }
    /**
     * @param null $default
     * @return mixed
     */
    public function getConditionHistogramContainer($default = null)
    {
        return $this->response->getConditionHistogramContainer($default);
    }
    /**
     * @param null $default
     * @return mixed|null
     */
    public function getPaginationOutput($default = null)
    {
        return $this->response->getPaginationOutput($default);
    }
    /**
     * @param null $default
     * @return mixed|null
     */
    public function getCategoryHistogramContainer($default = null)
    {
        return $this->response->getCategoryHistogramContainer($default);
    }
    /**
     * @param null $default
     * @return mixed|null
     */
    public function getErrors($default = null)
    {
        return $this->response->getErrors($default);
    }
    /**
     * @return bool
     */
    public function isErrorResponse() : bool
    {
        return $this->response->isErrorResponse();
    }
}