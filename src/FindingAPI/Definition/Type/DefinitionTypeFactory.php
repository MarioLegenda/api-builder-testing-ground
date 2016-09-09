<?php

namespace FindingAPI\Definition\Type;

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
     * @return UrlDefinitionType
     */
    public function getDefinitionType()
    {
        if ($this->request->getParameters()->getParameter('method') === 'get') {
            return new UrlDefinitionType();
        }
    }
}