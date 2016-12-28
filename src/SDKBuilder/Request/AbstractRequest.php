<?php

namespace SDKBuilder\Request;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use SDKBuilder\Exception\RequestException;

abstract class AbstractRequest
{
    /**
     * @var string $method
     */
    private $method = 'get';
    /**
     * @var RequestParameters $specialParameters
     */
    private $specialParameters;
    /**
     * @var RequestParameters $globalParameters
     */
    private $globalParameters;
    /**
     * AbstractRequest constructor.
     * @param RequestParameters $globalParameters
     * @param RequestParameters $specialParameters
     */
    public function __construct(RequestParameters $globalParameters, RequestParameters $specialParameters)
    {
        $this->specialParameters = $specialParameters;
        $this->globalParameters = $globalParameters;

        $this->globalParameters->restoreDefaults();
        $this->specialParameters->restoreDefaults();
    }
    /**
     * @return string
     */
    public function getMethod() : string
    {
        return $this->method;
    }
    /**
     * @return RequestParameters
     */
    public function getGlobalParameters() : RequestParameters
    {
        return $this->globalParameters;
    }
    /**
     * @return RequestParameters
     */
    public function getSpecialParameters() : RequestParameters
    {
        return $this->specialParameters;
    }
    /**
     * @param string $request
     */
    public function sendRequest(string $request) : Response
    {
        $client = new Client();

        return $client->request($this->getMethod(), $request);
    }
}