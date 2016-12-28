<?php

namespace SDKBuilder\SDK;

use FindingAPI\Core\Request\Method\MethodParameters;
use FindingAPI\Core\Request\RequestParameters;

abstract class AbstractFactory
{
    /**
     * @var RequestParameters $requestParameters
     */
    private $requestParameters;
    /**
     * @var MethodParameters $methodParameters
     */
    private $methodParameters;
    /**
     * AbstractFactory constructor.
     * @param RequestParameters $requestParameters
     * @param MethodParameters $methodParameters
     */
    public function __construct(RequestParameters $requestParameters, MethodParameters $methodParameters)
    {
        $this->requestParameters = $requestParameters;
        $this->methodParameters = $methodParameters;
    }
}