<?php

namespace FindingAPI\Processor\Factory;

use FindingAPI\Core\Request;

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