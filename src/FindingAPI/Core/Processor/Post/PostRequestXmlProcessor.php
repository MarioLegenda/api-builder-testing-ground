<?php

namespace FindingAPI\Core\Processor\Post;

use SDKBuilder\Processor\AbstractProcessor;
use SDKBuilder\Processor\ProcessorInterface;

class PostRequestXmlProcessor extends AbstractProcessor implements ProcessorInterface
{
    /**
     * @var string $processed
     */
    private $processed;
    /**
     * @return ProcessorInterface
     */
    public function process(): ProcessorInterface
    {
        $specialParameters = $this->request->getSpecialParameters();
        $mainUri = 'http://www.ebay.com/marketplace/search/v1/services';
        $operationName = $this->request->getGlobalParameters()->getParameter('operation_name')->getValue();

        $finalXml = '<?xml version="1.0" encoding="utf-8"?>';

        $operationNameStartTag = '<'.$operationName.'Request'.' xmlns=\''.$mainUri.'\'>';
        $operationNameEndTag = '</'.$operationName.'Request>';

        $finalXml.=$operationNameStartTag;

        foreach ($specialParameters as $specialParameter) {
            if ($specialParameter->getValue() !== null) {
                $finalXml.='<'.
                    $specialParameter->getRepresentation().
                    '>'.$specialParameter->getValue().
                    '</'.$specialParameter->getRepresentation().
                    '>';
            }
        }

        $finalXml.=$operationNameEndTag;

        $this->processed = $finalXml;

        return $this;
    }

    /**
     * @return string
     */
    public function getProcessed(): string
    {
        return $this->processed;
/*        return '<findItemsByKeywordsRequest xmlns="http://www.ebay.com/marketplace/search/v1/services">
   <keywords>harry potter phoenix</keywords>
</findItemsByKeywordsRequest>';*/
    }
}