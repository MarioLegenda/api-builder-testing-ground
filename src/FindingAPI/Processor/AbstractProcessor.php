<?php

namespace FindingAPI\Processor;

use FindingAPI\Core\Request;
use FindingAPI\Processor\Factory\DefinitionTypeInterface;

abstract class AbstractProcessor
{
    /**
     * @var Request $request
     */
    protected $request;
    /**
     * UrlProcessor constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
}