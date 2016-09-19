<?php

require __DIR__.'/../vendor/autoload.php';

use FindingAPI\FinderSearch;
use FindingAPI\Core\Request;
use FindingAPI\Definition\DefinitionFactory;
use FindingAPI\Core\Options;
use FindingAPI\Core\ItemFilter;

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
            ->addItemFilter(ItemFilter::AUTHORIZED_SELLER_ONLY, array(true))
            ->addItemFilter(ItemFilter::AVAILABLE_TO, array('AF'));

        $processed = $finder->send()->getProcessed();

        var_dump($processed);
    }
}