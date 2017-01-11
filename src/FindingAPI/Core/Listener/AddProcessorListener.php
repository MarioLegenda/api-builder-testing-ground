<?php

namespace FindingAPI\Core\Listener;

use FindingAPI\Core\Processor\Post\PostRequestXmlProcessor;
use SDKBuilder\Event\AddProcessorEvent;

class AddProcessorListener
{
    public function onAddProcessor(AddProcessorEvent $event)
    {
        $processorFactory = $event->getProcessorFactory();
        $request = $event->getRequest();

        if ($request->getMethod() === 'post') {
            $processorFactory->registerProcessor($request->getMethod(), PostRequestXmlProcessor::class);
        }
    }
}