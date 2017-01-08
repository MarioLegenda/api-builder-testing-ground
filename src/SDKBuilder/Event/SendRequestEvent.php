<?php

namespace SDKBuilder\Event;

use Symfony\Component\EventDispatcher\Event;

use SDKBuilder\Request\AbstractRequest;
use SDKBuilder\SDK\SDKInterface;

class SendRequestEvent extends Event
{
    /**
     * @var AbstractRequest $request
     */
    private $request;
    /**
     * @var SDKInterface $api
     */
    private $api;
    /**
     * PostSendRequestEvent constructor.
     * @param SDKInterface $api
     * @param AbstractRequest $request
     */
    public function __construct(SDKInterface $api, AbstractRequest $request)
    {
        $this->api = $api;
        $this->request = $request;
    }
    /**
     * @return AbstractRequest
     */
    public function getRequest() : AbstractRequest
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