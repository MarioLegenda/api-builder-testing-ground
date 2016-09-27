<?php

require __DIR__.'/../vendor/autoload.php';

use FindingAPI\FinderSearch;
use FindingAPI\Core\Request;
use FindingAPI\Definition\DefinitionFactory;
use FindingAPI\Core\Options;
use FindingAPI\Core\ItemFilter\ItemFilter;
use FindingAPI\Core\Information\Currency;
use FindingAPI\Core\Information\GlobalId;
use FindingAPI\Core\Information\SortOrder;

class MainTest extends PHPUnit_Framework_TestCase
{
    public function testRequest()
    {
        $request = new Request();

        $request
            ->setOperationName('findItemsByKeywords')
            ->setSortOrder(SortOrder::START_TIME_NEWEST)
            ->setPaginationInput(20, 'pageNumber')
            ->addOption(Options::SMART_GUESS_SYSTEM)
            ->addSearch(DefinitionFactory::andOperator('baseball card'))
            ->addItemFilter(ItemFilter::AUTHORIZED_SELLER_ONLY, array(true))
            ->addItemFilter(ItemFilter::AVAILABLE_TO, array('AF'))
            ->addItemFilter(ItemFilter::BEST_OFFER_ONLY, array(true))
            ->addItemFilter(ItemFilter::CHARITY_ONLY, array(true))
            ->addItemFilter(ItemFilter::CONDITION, array('New', 1000))
            ->addItemFilter(ItemFilter::CURRENCY, array(Currency::AUSTRALIAN))
            ->addItemFilter(ItemFilter::END_TIME_FROM, array(new \DateTime('1.1.2019')))
            ->addItemFilter(ItemFilter::END_TIME_TO, array(new \DateTime('1.1.2019')))
            ->addItemFilter(ItemFilter::EXCLUDE_AUTO_PAY, array(true))
            ->addItemFilter(ItemFilter::EXCLUDE_CATEGORY, array(123, 435))
            ->addItemFilter(ItemFilter::EXCLUDE_SELLER, array('Budala', 'Idiot'))
            ->addItemFilter(ItemFilter::EXPEDITED_SHIPPING_TYPE, array('Expedited'))
            ->addItemFilter(ItemFilter::FEATURED_ONLY, array(true))
            ->addItemFilter(ItemFilter::FEEDBACK_SCORE_MAX, array(9))
            ->addItemFilter(ItemFilter::FEEDBACK_SCORE_MIN, array(9))
            ->addItemFilter(ItemFilter::FREE_SHIPPING_ONLY, array(true))
            ->addItemFilter(ItemFilter::GET_IT_FAST_ONLY, array(true))
            ->addItemFilter(ItemFilter::HIDE_DUPLICATE_ITEMS, array(true))
            ->addItemFilter(ItemFilter::LISTED_IN, array(GlobalId::EBAY_AT))
            ->addItemFilter(ItemFilter::LISTING_TYPE, array('All', 'AuctionWithBIN'))
            ->addItemFilter(ItemFilter::LOCAL_PICKUP_ONLY, array(true))
            ->addItemFilter(ItemFilter::LOCAL_SEARCH_ONLY, array(true))
            ->addItemFilter(ItemFilter::LOCATED_IN, array('dz', 'ai'))
            ->addItemFilter(ItemFilter::LOTS_ONLY, array(true))
            ->addItemFilter(ItemFilter::MAX_BIDS, array(1))
            ->addItemFilter(ItemFilter::MAX_HANDLING_TIME, array(1))
            ->addItemFilter(ItemFilter::MAX_DISTANCE, array(6))
            ->addItemFilter(ItemFilter::MAX_PRICE, array(6.9));

        return $request;
    }
    /**
     * @depends testRequest
     */
    public function testFinder(Request $request)
    {
        $finder = FinderSearch::getInstance($request);

        $processed = $finder->send()->getProcessed();

        var_dump($processed);
    }
}