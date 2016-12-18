<?php

namespace FindingAPI\Core\Request\Method;

use FindingAPI\Core\Exception\FindingApiException;
use FindingAPI\Core\Information\OperationName;
use FindingAPI\Core\Request\Request;
use FindingAPI\Core\Request\RequestParameters;

class FindItemsByKeywords extends Request
{
    public function __construct(RequestParameters $globalParameters, RequestParameters $specialParameters)
    {
        parent::__construct($globalParameters, $specialParameters);

        $this->getGlobalParameters()->getParameter('operation_name')->setValue('findItemsByKeywords');
    }

    /**
     * @param string $searchString
     * @return Request
     */
    public function addKeywords(string $searchString) : Request
    {
        $this->getSpecialParameters()->getParameter('keywords')->setValue(urlencode($searchString));

        return $this;
    }
}