<?php

namespace FindingAPI\Core\Listener;

use FindingAPI\Core\Processor\Post\PostRequestXmlProcessor;
use SDKBuilder\Event\AddProcessorEvent;
use FindingAPI\Core\Processor\Get\GetItemFiltersProcessor;
use SDKBuilder\Request\RequestInterface;

class AddProcessorListener
{
    public function onAddProcessor(AddProcessorEvent $event)
    {
        $processorFactory = $event->getProcessorFactory();
        $request = $event->getRequest();

        if ($request->getMethod() === 'get') {
            $processorFactory->registerCallbackProcessor($request->getMethod(), function(RequestInterface $request) {
                $itemFilterStorage = $request->getDynamicStorage();

                if (!empty($itemFilterStorage)) {
                    if ($request->getMethod() === 'get') {
                        return new GetItemFiltersProcessor($request, $itemFilterStorage);
                    }
                }
            });
        }

        if ($request->getMethod() === 'post') {
            $processorFactory->registerProcessor($request->getMethod(), PostRequestXmlProcessor::class);
        }
    }
}