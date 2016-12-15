<?php

namespace FindingAPI\Core\Request\Method;

use FindingAPI\Core\Exception\FindingApiException;
use FindingAPI\Core\Information\OperationName;
use FindingAPI\Core\Request\Request;
use FindingAPI\Core\Request\RequestParameters;

class FindItemsByKeywordsRequest extends Request
{
    /**
     * FindItemsByKeywordsRequest constructor.
     * @param RequestParameters $parameters
     */
    public function __construct(RequestParameters $parameters)
    {
        $parameters->restoreDefaults();

        parent::__construct($parameters);

        $this->setOperationName(OperationName::FIND_ITEMS_BY_KEYWORDS);
        $this->setResponseDataFormat('xml');
    }
    /**
     * @param string $searchString
     * @return Request
     */
    public function addKeywords(string $searchString) : Request
    {
        return parent::addKeywords($searchString);
    }
    /**
     * @param int $categoryId
     * @return Request
     * @throws FindingApiException
     */
    public function setCategoryId(int $categoryId): Request
    {
        throw new FindingApiException('Cannot set categoryId on findItemsByKeywords method call. Only \'keywords\' is allowed');
    }
    /**
     * @return Request
     * @throws FindingApiException
     */
    public function enableDescriptionSearch(): Request
    {
        throw new FindingApiException('Cannot set \'enableDescription\' on findItemsByKeywords method call. Only \'keywords\' is allowed');
    }
}