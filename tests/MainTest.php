<?php

require __DIR__.'/../vendor/autoload.php';

use FindingAPI\FinderSearch;
use FindingAPI\Core\Request;
use FindingAPI\Core\RequestParameters;
use FindingAPI\Definition\DefinitionFactory;

class TempTesting extends PHPUnit_Framework_TestCase
{
    public function testRequest()
    {
        $request = new Request();
        $request
            ->setEbayUrl('http://svcs.ebay.com/services/search/FindingService/v1')
            ->setServiceVersion('1.0.0')
            ->setMethod(RequestParameters::REQUEST_METHOD_GET)
            ->setOperationName('findItemsByKeywords')
            ->setResponseDataFormat(RequestParameters::RESPONSE_DATA_FORMAT_XML)
            ->setSecurityAppId('Mariokrl-testing-PRD-ee6e68035-e73c8a53');

        return $request;
    }
    /**
     * @depends testRequest
     */
    public function testFinder(Request $request)
    {
        $finder = FinderSearch::getInstance($request);

        $finder
            ->search(DefinitionFactory::andOperator('baseball card'))
            ->search(DefinitionFactory::exactSearchOperator('someshit'))
            ->search(DefinitionFactory::orOperator('(some,shit)'));

        $finder->send();
    }
}