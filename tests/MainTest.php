<?php

require __DIR__.'/../vendor/autoload.php';

use FindingAPI\FinderSearch;
use FindingAPI\Core\Request;
use FindingAPI\Definition\DefinitionFactory;
use FindingAPI\Core\Options;

class TempTesting extends PHPUnit_Framework_TestCase
{
    public function testRequest()
    {
        $request = new Request();

        $request->setOperationName('findItemsByKeywords');

        return $request;
    }
    /**
     * @depends testRequest
     */
    public function testFinder(Request $request)
    {
        $finder = FinderSearch::getInstance($request);

        $finder
            ->addOption(Options::SMART_GUESS_SYSTEM)
            ->addSearch(DefinitionFactory::andOperator('baseball card'))
            ->addSearch(DefinitionFactory::exactSearchOperator('someshit'))
            ->addSearch(DefinitionFactory::orOperator('(some,shit)'))
            ->addSearch(DefinitionFactory::notOperator('baseball -card'));

        $finder->send();
    }
}