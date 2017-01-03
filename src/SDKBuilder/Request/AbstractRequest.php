<?php

namespace SDKBuilder\Request;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use SDKBuilder\Exception\RequestException;
use SDKBuilder\Exception\RequestParametersException;

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
     * @param string $name
     * @param $value
     * @return RequestParameters
     * @throws RequestParametersException
     */
    public function setGlobalParameter(string $name, $value) : RequestParameters
    {
        if (!$this->globalParameters->hasParameter($name)) {
            throw new RequestParametersException('global_parameter \''.$name.'\' does not exist');
        }

        $this->globalParameters->getParameter($name)->setValue($value);

        return $this->globalParameters;
    }
    /**
     * @return RequestParameters
     */
    public function getGlobalParameters() : RequestParameters
    {
        return $this->globalParameters;
    }
    /**
     * @param string $name
     * @param $value
     * @return RequestParameters
     * @throws RequestParametersException
     */
    public function setSpecialParameter(string $name, $value) : RequestParameters
    {
        if (!$this->specialParameters->hasParameter($name)) {
            throw new RequestParametersException('special_parameter \''.$name.'\' does not exist');
        }

        $this->specialParameters->getParameter($name)->setValue($value);

        return $this->specialParameters;
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
     * @return Response
     */
    public function sendRequest(string $request) : Response
    {
        $client = new Client();

        return $client->request($this->getMethod(), $request);
    }
}