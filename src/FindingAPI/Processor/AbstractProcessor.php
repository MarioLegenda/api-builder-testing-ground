<?php

namespace FindingAPI\Processor;

use FindingAPI\Core\Request\Request;

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