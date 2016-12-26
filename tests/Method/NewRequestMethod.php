<?php

namespace Test\Method;

use FindingAPI\Core\Request\Request;
use FindingAPI\Core\Request\RequestParameters;

class NewRequestMethod extends Request
{
    /**
     * NewRequestMethod constructor.
     * @param RequestParameters $globalParameters
     * @param RequestParameters $specialParameters
     */
    public function __construct(RequestParameters $globalParameters, RequestParameters $specialParameters)
    {
        parent::__construct($globalParameters, $specialParameters);
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