<?php

namespace FindingAPI\Core\Response;

use FindingAPI\Core\Exception\ResponseException;
use FindingAPI\Core\ResponseParser\ResponseItem\RootItem;

class JsonResponse implements ResponseInterface, ArrayConvertableInterface
{
    /**
     * @var array $jsonResponse
     */
    private $jsonResponse;
    /**
     * JsonResponse constructor.
     * @param ArrayConvertableInterface $xmlResponse
     */
    public function __construct(ArrayConvertableInterface $xmlResponse)
    {
        $this->jsonResponse = $xmlResponse->toArray();
    }
    /**
     * @throws ResponseException
     */
    public function getRoot() : RootItem
    {
        throw new ResponseException('You cannot use '.ResponseInterface::class.' methods with '.JsonResponse::class.'. You can only convert it to json');
    }
    /**
     * @param null|mixed $default
     * @throws ResponseException
     */
    public function getAspectHistogramContainer($default = null)
    {
        throw new ResponseException('You cannot use '.ResponseInterface::class.' methods with '.JsonResponse::class.'. You can only convert it to json');
    }
    /**
     * @param null $default
     * @throws ResponseException
     */
    public function getSearchResults($default = null)
    {
        throw new ResponseException('You cannot use '.ResponseInterface::class.' methods with '.JsonResponse::class.'. You can only convert it to json');
    }
    /**
     * @param null $default
     * @throws ResponseException
     */
    public function getConditionHistogramContainer($default = null)
    {
        throw new ResponseException('You cannot use '.ResponseInterface::class.' methods with '.JsonResponse::class.'. You can only convert it to json');
    }
    /**
     * @param null $default
     * @throws ResponseException
     */
    public function getPaginationOutput($default = null)
    {
        throw new ResponseException('You cannot use '.ResponseInterface::class.' methods with '.JsonResponse::class.'. You can only convert it to json');
    }
    /**
     * @param null $default
     * @return mixed|null
     * @throws ResponseException
     */
    public function getCategoryHistogramContainer($default = null)
    {
        throw new ResponseException('You cannot use '.ResponseInterface::class.' methods with '.JsonResponse::class.'. You can only convert it to json');
    }
    /**
     * @param null $default
     * @return mixed|null
     * @throws ResponseException
     */
    public function getErrors($default = null)
    {
        throw new ResponseException('You cannot use '.ResponseInterface::class.' methods with '.JsonResponse::class.'. You can only convert it to json');
    }
    /**
     * @return bool
     * @throws ResponseException
     */
    public function isErrorResponse() : bool
    {
        throw new ResponseException('You cannot use '.ResponseInterface::class.' methods with '.JsonResponse::class.'. You can only use ResponseInterface::getRawResponse() or convert it to json');
    }
    /**
     * @return string
     */
    public function getRawResponse() : string
    {
        return json_encode($this->jsonResponse);
    }
    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->jsonResponse;
    }
}