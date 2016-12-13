<?php

namespace FindingAPI\Processor\Get;

use FindingAPI\Processor\{ AbstractProcessor, ProcessorInterface };

class GetRequestParametersProcessor extends AbstractProcessor implements ProcessorInterface
{
    /**
     * @var string $processed
     */
    private $processed = '';
    /**
     * @return ProcessorInterface
     */
    public function process() : ProcessorInterface
    {
        $parameters = $this->request->getRequestParameters();
        $parameters->excludeFromLoop(array('method', 'ebay_url'));

        $ebayUrl = $parameters->getParameter('ebay_url')->getValue();

        $finalUrl = $ebayUrl.'?';

        foreach ($parameters as $parameter) {
            $name = $parameter->getName();

            $value = $parameter->getValue();

            if (!empty($value)) {
                $finalUrl.=$name.'='.$value.'&';
            }
        }

        $this->processed = $finalUrl;

        return $this;
    }
    /**
     * @return string
     */
    public function getProcessed() : string
    {
        return $this->processed;
    }
}