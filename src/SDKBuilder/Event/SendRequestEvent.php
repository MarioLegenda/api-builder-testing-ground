<?php

namespace SDKBuilder\Event;

use SDKBuilder\Request\RequestInterface;
use Symfony\Component\EventDispatcher\Event;

use SDKBuilder\SDK\SDKInterface;

class SendRequestEvent extends Event
{
    /**
     * @var RequestInterface $request
     */
    private $request;
    /**
     * @var SDKInterface $api
     */
    private $api;
    /**
     * PostSendRequestEvent constructor.
     * @param SDKInterface $api
     * @param RequestInterface $request
     */
    public function __construct(SDKInterface $api, RequestInterface $request)
    {
        $this->api = $api;
        $this->request = $request;
    }
    /**
     * @return RequestInterface
     */
    public function getRequest() : RequestInterface
    {
        return $this->request;
    }
    /**
     * @return SDKInterface
     */
    public function getApi() : SDKInterface
    {
        return $this->api;
    }
}