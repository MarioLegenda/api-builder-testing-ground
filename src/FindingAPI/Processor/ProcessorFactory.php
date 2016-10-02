<?php

namespace FindingAPI\Processor;

use FindingAPI\Core\Request;
use FindingAPI\Definition\Type\DefinitionTypeInterface;

class ProcessorFactory
{
    /**
     * @param Request $request
     * @return GetProcessor
     */
    public static function getProcessor(Request $request, DefinitionTypeInterface $definitionType)
    {
        $method = $request->getRequestParameters()->getParameter('method')->getValue();

        $class = 'FindingAPI\Processor\\'.ucfirst($method).'Processor';

        return new $class($request, $definitionType);
    }
}