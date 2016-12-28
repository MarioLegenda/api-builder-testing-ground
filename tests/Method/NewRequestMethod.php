<?php

namespace Test\Method;

use FindingAPI\Core\Request\Request;
use SDKBuilder\Request\RequestParameters;

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

        $this->getGlobalParameters()->getParameter('operation_name')->setValue('newRequestMethod');
    }
    /**
     * @param string $searchString
     * @return Request
     */
    public function setNewParameter(string $searchString) : Request
    {
        $this->getSpecialParameters()->getParameter('new_parameter')->setValue(urlencode($searchString));

        return $this;
    }
}