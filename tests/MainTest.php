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
            ->addItemFilter(ItemFilter::AVAILABLE_TO, array('AF'))
            ->addItemFilter(ItemFilter::BEST_OFFER_ONLY, array(true))
            ->addItemFilter(ItemFilter::CHARITY_ONLY, array(true))
            ->addItemFilter(ItemFilter::CONDITION, array('New', 1000))
            ->addItemFilter(ItemFilter::CURRENCY, array(ItemFilter\Currency::AUSTRALIAN))
            ->addItemFilter(ItemFilter::END_TIME_FROM, array(new \DateTime('1.1.2019')))
            ->addItemFilter(ItemFilter::END_TIME_TO, array(new \DateTime('1.1.2019')))
            ->addItemFilter(ItemFilter::EXCLUDE_AUTO_PAY, array(true))
            ->addItemFilter(ItemFilter::EXCLUDE_CATEGORY, array(123, 435));

        $processed = $finder->send()->getProcessed();

        var_dump($processed);
    }
}