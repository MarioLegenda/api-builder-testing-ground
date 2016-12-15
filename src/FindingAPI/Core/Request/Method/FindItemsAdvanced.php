<?php

namespace FindingAPI\Core\Request\Method;

use FindingAPI\Core\Request\Request;
use FindingAPI\Core\Information\OperationName;
use FindingAPI\Core\Request\RequestParameters;

class FindItemsAdvanced extends Request
{
    /**
     * FindItemsByKeywordsRequest constructor.
     * @param RequestParameters $parameters
     */
    public function __construct(RequestParameters $parameters)
    {
        $parameters->restoreDefaults();

        parent::__construct($parameters);

        $this->setOperationName(OperationName::FIND_ITEMS_ADVANCED);
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
     */
    public function setCategoryId(int $categoryId) : Request
    {
        return parent::setCategoryId($categoryId);
    }
    /**
     * @return Request
     */
    public function enableDescriptionSearch() : Request
    {
        return parent::enableDescriptionSearch();
    }
}