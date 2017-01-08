<?php

namespace FindingAPI;

use FindingAPI\Core\Response\ResponseInterface;
use SDKBuilder\AbstractSDK;

class FindingAPI extends AbstractSDK
{
    /**
     * @var ResponseInterface
     */
    private $response;
    /**
     * @param ResponseInterface $response
     * @return FindingAPI
     */
    public function setResponse(ResponseInterface $response) : FindingAPI
    {
        $this->response = $response;

        return $this;
    }
    /**
     * @return ResponseInterface
     */
    public function getResponse()
    {
        if ($this->response instanceof ResponseInterface) {
            return $this->response;
        }

        return $this->response;
    }
}