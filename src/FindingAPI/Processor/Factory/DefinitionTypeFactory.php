<?php

namespace FindingAPI\Processor\Factory;

use FindingAPI\Core\Request;

class DefinitionTypeFactory
{
    /**
     * @var Request $request
     */
    private $request;
    /**
     *  constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    /**
     * @return FindingAPI\Processor\GetDefinitionType
     */
    public function getDefinitionType()
    {
        $method = $this->request->getRequestParameters()->getParameter('method')->getValue();

        $class = 'FindingAPI\Definition\Type\\'.ucfirst(strtolower($method)).'DefinitionType';

        return new $class();
    }
}