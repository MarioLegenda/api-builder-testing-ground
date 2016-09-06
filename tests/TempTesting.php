<?php

require __DIR__.'/../vendor/autoload.php';

use FindingAPI\FinderSearch;
use FindingAPI\Definition\Definition;
use FindingAPI\Core\Request\Request;

class TempTesting extends PHPUnit_Framework_TestCase
{
    public function testMain()
    {
        $request = new Request();
        $request
            ->setServiceVersion('1.0.0')
            ->setMethod('POST')
            ->setOperationName('findItemsByKeywords')
            ->setResponseData('xml')
            ->setSecurityAppId('Mariokrl-testing-PRD-ee6e68035-e73c8a53');

        $finderSearch = FinderSearch::getInstance($request);

        $finderSearch->search(Definition::andOperator('baseball card'));
    }
}