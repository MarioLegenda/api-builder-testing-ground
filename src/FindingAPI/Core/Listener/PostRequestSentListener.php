<?php

namespace FindingAPI\Core\Listener;

use SDKBuilder\Event\PostSendRequestEvent;
use FindingAPI\Core\Response\ResponseProxy;

class PostRequestSentListener
{
    /**
     * @param PostSendRequestEvent $event
     * @return null
     */
    public function onRequestSent(PostSendRequestEvent $event)
    {
        $api = $event->getApi();
        $request = $event->getRequest();

        $response = new ResponseProxy(
            $api->getResponseBody(),
            $request->getResponseFormat()
        );

        $api->setResponse($response);
    }
}