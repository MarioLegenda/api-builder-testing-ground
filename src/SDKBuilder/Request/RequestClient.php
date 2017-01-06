<?php

namespace SDKBuilder\Request;

class RequestClient
{
    /**
     * @var string $method
     */
    private $method;
    /**
     * @var string $uri
     */
    private $uri;
    /**
     * @var array $headers
     */
    private $headers;
    /**
     * RequestClient constructor.
     * @param string $method
     * @param string $uri
     * @param array $headers
     */
    public function __construct(string $method, string $uri, array $headers)
    {
        $this->method = $method;
        $this->uri = $uri;
        $this->headers = $headers;
    }
    /**
     * @param string $method
     * @return RequestClient
     */
    public function setMethod(string $method) : RequestClient
    {
        $this->method = $method;

        return $this;
    }
    /**
     * @return string
     */
    public function getMethod() : string
    {
        return $this->method;
    }
    /**
     * @param string $uri
     * @return RequestClient
     */
    public function setUri(string $uri) : RequestClient
    {
        $this->uri = $uri;

        return $this;
    }
    /**
     * @return string
     */
    public function getUri() : string
    {
        return $this->uri;
    }
    /**
     * @param array $headers
     * @return RequestClient
     */
    public function setHeaders(array $headers) : RequestClient
    {
        $this->headers = $headers;

        return $this;
    }
    /**
     * @param string $header
     * @param string $headerValue
     * @return RequestClient
     */
    public function addHeader(string $header, string $headerValue) : RequestClient
    {
        $this->headers[$header] = $headerValue;

        return $this;
    }
    /**
     * @return array
     */
    public function getHeaders() : array
    {
        return $this->headers;
    }

    public function send() : void
    {

    }

    public function getResponse()
    {

    }
}