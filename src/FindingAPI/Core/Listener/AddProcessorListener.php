<?php

namespace FindingAPI\Core\Listener;

use SDKBuilder\Event\AddProcessorEvent;
use SDKBuilder\Request\AbstractRequest;
use FindingAPI\Core\Processor\Get\GetItemFiltersProcessor;

class AddProcessorListener
{
    public function onAddProcessor(AddProcessorEvent $event)
    {
        $processorFactory = $event->getProcessorFactory();
        $request = $event->getRequest();

        $processorFactory->registerCallbackProcessor($request->getMethod(), function(AbstractRequest $request) {
            $itemFilterStorage = $request->getItemFilterStorage();

            if (!empty($itemFilterStorage)) {
                if ($request->getMethod() === 'get') {
                    return new GetItemFiltersProcessor($request, $itemFilterStorage);
                }
            }
        });
    }
}