<?php

namespace FindingAPI\Processor;

use FindingAPI\Core\Request;
use FindingAPI\Definition\Type\DefinitionTypeInterface;

class UrlProcessor implements ProcessorInterface
{
    /**
     * @var Request $request
     */
    private $request;
    /**
     * @var DefinitionTypeInterface $definitionType
     */
    private $definitionType;
    /**
     * UrlProcessor constructor.
     * @param Request $request
     * @param DefinitionTypeInterface $definitionType
     */
    public function __construct(Request $request, DefinitionTypeInterface $definitionType)
    {
        $this->request = $request;
        $this->definitionType = $definitionType;
    }
    /**
     * @return string
     */
    public function process() : string
    {
        $processed = $this->definitionType->getProcessed();

        $parameters = $this->request->getRequestParameters();

        $ebayUrl = $parameters->getParameter('ebay_url')->getValue();
        $keywords = urlencode($processed);

        $finalUrl = $ebayUrl.'?';

        foreach ($parameters as $parameter) {
            if ($parameter->getName() === 'method' or $parameter->getName() === 'ebay_url') {
                continue;
            }

            $name = $parameter->getName();
            $value = $parameter->getValue();

            $finalUrl.=$name.'='.$value.'&';
        }

        $finalUrl.='keywords='.$keywords;

        return $finalUrl;
    }
}