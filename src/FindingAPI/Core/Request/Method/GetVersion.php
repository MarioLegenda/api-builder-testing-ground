<?php

namespace FindingAPI\Core\Request\Method;

use FindingAPI\Core\Request\Request;
use SDKBuilder\Dynamic\DynamicStorage;
use SDKBuilder\Request\RequestParameters;

class GetVersion extends Request
{
    /**
     * GetVersion constructor.
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

        $this->getGlobalParameters()->getParameter('operation_name')->setValue('getVersion');
    }
}