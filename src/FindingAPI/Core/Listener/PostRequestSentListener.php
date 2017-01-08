<?php

namespace FindingAPI\Core\Listener;


use FindingAPI\Core\Exception\FindingApiException;
use SDKBuilder\Event\PostSendRequestEvent;
use FindingAPI\Core\Response\ResponseInterface;
use FindingAPI\Core\Response\ResponseProxy;

class PostRequestSentListener
{
    public function onRequestSent(PostSendRequestEvent $event)
    {
        $api = $event->getApi();
        $request = $event->getRequest();

        if ($api->getResponseObject() instanceof ResponseInterface) {
            return null;
        }

        $response = new ResponseProxy(
            $api->getUnparsedResponse(),
            $api->getResponseClient(),
            $request->getResponseFormat()
        );

        $api->setResponseObject($response);

        if (!$api->getResponse() instanceof ResponseInterface) {
            throw new FindingApiException('Response had to be set until now in '.PostRequestSentListener::class);
        }
    }
}