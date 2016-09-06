<?php

namespace FindingAPI\Core\Request;

class Request
{
    /**
     * @var string $method
     */
    private $method;
    /**
     * @var string $serviceVersion
     */
    private $serviceVersion;
    /**
     * @var string $operationName
     */
    private $operationName;
    /**
     * @var string $responseData
     */
    private $responseData;
    /**
     * @var string $securityAppId
     */
    private $securityAppId;
    /**
     * @param string $method
     * @return Request
     */
    public function setMethod(string $method) : Request
    {
        $this->method = $method;

        return $this;
    }
    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }
    /**
     * @return mixed
     */
    public function getServiceVersion()
    {
        return $this->serviceVersion;
    }
    /**
     * @param mixed $serviceVersion
     * @return Request
     */
    public function setServiceVersion(string $serviceVersion) : Request
    {
        $this->serviceVersion = $serviceVersion;

        return $this;
    }
    /**
     * @return mixed
     */
    public function getOperationName()
    {
        return $this->operationName;
    }
    /**
     * @param mixed $operationName
     */
    public function setOperationName(string $operationName) : Request
    {
        $this->operationName = $operationName;

        return $this;
    }
    /**
     * @return mixed
     */
    public function getResponseData()
    {
        return $this->responseData;
    }
    /**
     * @param mixed $responseData
     * @return Request
     */
    public function setResponseData(string $responseData) : Request
    {
        $this->responseData = $responseData;

        return $this;
    }

    /**
     * @return string
     */
    public function getSecurityAppId()
    {
        return $this->securityAppId;
    }

    /**
     * @param string $securityAppId
     * @return Request
     */
    public function setSecurityAppId(string $securityAppId) : Request
    {
        $this->securityAppId = $securityAppId;

        return $this;
    }
}