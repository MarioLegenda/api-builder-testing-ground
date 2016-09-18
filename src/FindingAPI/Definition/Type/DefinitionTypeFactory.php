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
     * @return UrlDefinitionType
     */
    public function getDefinitionType()
    {
        $method = $this->request->getParameters()->getParameter('method')->getValue();

        if (strtolower($method) === 'get') {
            return new UrlDefinitionType();
        }

        throw new FindingApiException('TEMPORARY EXCEPTION. DefinitionTypeFactory::getDefinitionType() should return UrlDefinitionType');
    }
}