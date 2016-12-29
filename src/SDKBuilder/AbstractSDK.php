<?php

namespace SDKBuilder;

use SDKBuilder\Request\AbstractRequest;
use SDKBuilder\Request\Method\MethodParameters;
use SDKBuilder\Request\Method\Method;
use SDKBuilder\Request\Parameter;

abstract class AbstractSDK
{
    /**
     * @var AbstractRequest $request
     */
    protected $request;
    /**
     * @var MethodParameters $methodParameters
     */
    protected $methodParameters;
    /**
     * AbstractSDK constructor.
     * @param AbstractRequest $request
     * @param MethodParameters $methodParameters
     */
    public function __construct(AbstractRequest $request, MethodParameters $methodParameters)
    {
        $this->request = $request;
        $this->methodParameters = $methodParameters;
    }
    /**
     * @param Method $method
     * @return AbstractSDK
     */
    public function addMethod(Method $method) : AbstractSDK
    {
        $validMethodsParameter = $this->getRequest()->getGlobalParameters()->getParameter($this->methodParameters->getValidMethodsParameter());

        $method->validate($validMethodsParameter);

        $this->methodParameters->addMethod($method);

        return $this;
    }
    /**
     * @param string $parameterType
     * @param Parameter $parameter
     * @return AbstractSDK
     */
    public function addParameter(string $parameterType, Parameter $parameter) : AbstractSDK
    {
        if ($parameterType === 'global_parameter') {
            $this->getRequest()->getGlobalParameters()->addParameter($parameter);

            return $this;
        }

        if ($parameterType === 'special_parameter') {
            $this->getRequest()->getSpecialParameters()->addParameter($parameter);
        }

        return $this;
    }
    /**
     * @return AbstractRequest
     */
    public function getRequest() : AbstractRequest
    {
        return $this->request;
    }
}