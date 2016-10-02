<?php

namespace FindingAPI\Definition\Type;

use FindingAPI\Core\Exception\FindingApiException;
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
     * @return GetDefinitionType
     */
    public function getDefinitionType()
    {
        $method = $this->request->getRequestParameters()->getParameter('method')->getValue();

        $class = 'FindingAPI\Definition\Type\\'.ucfirst(strtolower($method)).'DefinitionType';

        return new $class();
    }
}