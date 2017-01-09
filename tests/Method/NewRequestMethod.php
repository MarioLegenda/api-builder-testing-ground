<?php

namespace Test\Method;

use FindingAPI\Core\Request\Request;
use SDKBuilder\Dynamic\DynamicStorage;
use SDKBuilder\Request\RequestParameters;

class NewRequestMethod extends Request
{
    /**
     * NewRequestMethod constructor.
     * @param RequestParameters $globalParameters
     * @param RequestParameters $specialParameters
     * @param DynamicStorage $dynamicStorage
     */
    public function __construct(
        RequestParameters $globalParameters,
        RequestParameters $specialParameters,
        DynamicStorage $dynamicStorage
    )
    {
        parent::__construct($globalParameters, $specialParameters, $dynamicStorage);

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