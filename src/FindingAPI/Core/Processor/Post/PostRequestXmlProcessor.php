<?php

namespace FindingAPI\Core\Processor\Post;

use SDKBuilder\Processor\AbstractProcessor;
use SDKBuilder\Processor\ProcessorInterface;

class PostRequestXmlProcessor extends AbstractProcessor implements ProcessorInterface
{
    public function process(): ProcessorInterface
    {
        return $this;
    }

    public function getProcessed(): string
    {
        return '<findItemsByKeywordsRequest xmlns="http://www.ebay.com/marketplace/search/v1/services">
   <keywords>harry potter phoenix</keywords>
</findItemsByKeywordsRequest>';
    }
}