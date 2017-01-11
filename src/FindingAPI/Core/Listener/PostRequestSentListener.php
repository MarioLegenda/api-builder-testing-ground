<?php

namespace FindingAPI\Core\Listener;

use SDKBuilder\Event\PostSentRequestEvent;
use FindingAPI\Core\Response\ResponseProxy;

class PostRequestSentListener
{
    /**
     * @param PostSentRequestEvent $event
     * @return null
     */
    public function onRequestSent(PostSentRequestEvent $event)
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