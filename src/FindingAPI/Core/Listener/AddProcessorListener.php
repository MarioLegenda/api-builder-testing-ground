<?php

namespace FindingAPI\Core\Listener;

use FindingAPI\Core\Processor\Post\PostRequestXmlProcessor;
use SDKBuilder\Event\AddProcessorEvent;
use SDKBuilder\Request\AbstractRequest;
use FindingAPI\Core\Processor\Get\GetItemFiltersProcessor;

class AddProcessorListener
{
    public function onAddProcessor(AddProcessorEvent $event)
    {
        $processorFactory = $event->getProcessorFactory();
        $request = $event->getRequest();

        if ($request->getMethod() === 'get') {
            $processorFactory->registerCallbackProcessor($request->getMethod(), function(AbstractRequest $request) {
                $itemFilterStorage = $request->getItemFilterStorage();

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