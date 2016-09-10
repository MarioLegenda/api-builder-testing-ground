<?php

namespace FindingAPI\Processor;

use FindingAPI\Core\Request;
use FindingAPI\Definition\Type\DefinitionTypeInterface;

class ProcessorFactory
{
    /**
     * @param Request $request
     * @return UrlProcessor
     */
    public static function getProcessor(Request $request, DefinitionTypeInterface $definitionType)
    {
        $method = $request->getParameters()->getParameter('method')->getValue();

        if ($method === 'get') {
            return new UrlProcessor($request, $definitionType);
        }
    }
}