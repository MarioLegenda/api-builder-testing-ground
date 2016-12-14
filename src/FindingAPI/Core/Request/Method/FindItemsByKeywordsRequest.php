<?php

namespace FindingAPI\Core\Request\Method;

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
        parent::__construct($parameters);

        $this->setOperationName(OperationName::FIND_ITEMS_BY_KEYWORDS);
        $this->setResponseDataFormat('xml');
    }
    /**
     * @param string $searchString
     * @return FindItemsByKeywordsRequest
     */
    public function addKeyword(string $searchString) : FindItemsByKeywordsRequest
    {
        $this->getRequestParameters()->setParameter('keywords', urlencode($searchString));

        return $this;
    }
}