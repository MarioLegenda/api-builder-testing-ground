<?php

namespace FindingAPI\Processor;

use FindingAPI\Core\Request;
use FindingAPI\Definition\Type\DefinitionTypeInterface;
use FindingAPI\Definition\Type\UrlDefinitionType;

class ProcessorFactory
{
    /**
     * @param Request $request
     * @return UrlProcessor
     */
    public static function getProcessor(Request $request, DefinitionTypeInterface $definitionType)
    {
        if ($definitionType instanceof UrlDefinitionType) {
            return new UrlProcessor($request, $definitionType);
        }
    }
}