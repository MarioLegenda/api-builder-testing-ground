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
        parent::__construct($parameters);

        $this->setOperationName(OperationName::FIND_ITEMS_BY_KEYWORDS);
        $this->setResponseDataFormat('xml');
    }
    /**
     * @param string $searchString
     * @return FindItemsAdvanced
     */
    public function addKeyword(string $searchString) : FindItemsAdvanced
    {
        $this->getRequestParameters()->setParameter('keywords', urlencode($searchString));

        return $this;
    }
    /**
     * @param int $categoryId
     * @return FindItemsAdvanced
     */
    public function setCategoryId(int $categoryId) : FindItemsAdvanced
    {
        $this->getRequestParameters()->setParameter('categoryId', $categoryId);

        return $this;
    }
}