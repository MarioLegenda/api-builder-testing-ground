<?php

namespace FindingAPI\Core\Request\Method;

use FindingAPI\Core\Request\Request;
use SDKBuilder\Request\RequestParameters;

class GetVersion extends Request
{
    /**
     * GetVersion constructor.
     * @param RequestParameters $globalParameters
     * @param RequestParameters $specialParameters
     */
    public function __construct(RequestParameters $globalParameters, RequestParameters $specialParameters)
    {
        parent::__construct($globalParameters, $specialParameters);

        $this->getGlobalParameters()->getParameter('operation_name')->setValue('getVersion');
    }
}