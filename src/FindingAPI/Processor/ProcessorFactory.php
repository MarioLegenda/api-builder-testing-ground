<?php

namespace FindingAPI\Processor;

use FindingAPI\Core\Request;
use FindingAPI\Definition\Type\DefinitionTypeInterface;
use FindingAPI\Definition\Type\GetDefinitionType;
use FindingAPI\Definition\Type\UrlDefinitionType;

class ProcessorFactory
{
    /**
     * @param Request $request
     * @return UrlProcessor
     */
    public static function getProcessor(Request $request, DefinitionTypeInterface $definitionType)
    {
        if ($definitionType instanceof DefinitionTypeInterface) {
            return new UrlProcessor($request, $definitionType);
        }
    }
}