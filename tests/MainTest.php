<?php

namespace Test;

require __DIR__.'/../vendor/autoload.php';

use FindingAPI\FinderSearch;
use FindingAPI\Core\Request;
use FindingAPI\Definition\DefinitionFactory;
use FindingAPI\Core\ItemFilter\ItemFilter;
use FindingAPI\Core\Information\Currency;
use FindingAPI\Core\Information\SortOrder;
use FindingAPI\Core\Information\GlobalId;

class MainTest extends \PHPUnit_Framework_TestCase
{
    public function testItemFilters()
    {
        $request = new Request();

        $itemFilterStorage = $request->getItemFilterStorage();

        // single value item filter
        $itemFilterStorage->addItemFilter(array(
            'SingleValueItemFilter' => array(
                'object' => 'Test\ItemFilter\SingleValueItemFilter',
                'value' => null,
                'multiple_values' => false,
                'date_time' => false,
            ),
        ));

        $this->assertTrue($itemFilterStorage->hasItemFilter('SingleValueItemFilter'));

        $itemFilterStorage->removeItemFilter('SingleValueItemFilter');

        $this->assertFalse($itemFilterStorage->hasItemFilter('SingleValueItemFilter'));

        // multiple value item filter

        $itemFilterStorage->addItemFilter(array(
            'MultipleValueItemFilter' => array(
                'object' => 'Test\ItemFilter\MultipleValueItemFilter',
                'value' => null,
                'multiple_values' => true,
                'date_time' => false,
            ),
        ));
    }

    public function testRequest()
    {
        $request = new Request();

        $request
            ->setOperationName('findItemsByKeywords')
            ->setBuyerPostalCode(31000)
            ->setSortOrder(SortOrder::START_TIME_NEWEST)
            ->setPaginationInput(20, 'pageNumber')
            //->addOption(Options::SMART_GUESS_SYSTEM)
            ->addSearch(DefinitionFactory::customDefinition('harry potter'))
            ->addItemFilter(ItemFilter::AUTHORIZED_SELLER_ONLY, array(true))
            ->addItemFilter(ItemFilter::AVAILABLE_TO, array('AF'))
            ->addItemFilter(ItemFilter::BEST_OFFER_ONLY, array(true))
            ->addItemFilter(ItemFilter::CHARITY_ONLY, array(true))
            ->addItemFilter(ItemFilter::CONDITION, array('New', 1000, 1500, 1750))
            ->addItemFilter(ItemFilter::CURRENCY, array(Currency::AUSTRALIAN))
            ->addItemFilter(ItemFilter::END_TIME_FROM, array(new \DateTime('1.1.2018 21:23:38')))
            ->addItemFilter(ItemFilter::END_TIME_TO, array(new \DateTime('1.1.2019')))
//            ->addItemFilter(ItemFilter::EXCLUDE_AUTO_PAY, array(true))
//            ->addItemFilter(ItemFilter::EXCLUDE_CATEGORY, array(123, 435))
//            ->addItemFilter(ItemFilter::EXCLUDE_SELLER, array('Budala', 'Idiot'));
//            ->addItemFilter(ItemFilter::EXPEDITED_SHIPPING_TYPE, array('Expedited'))
//            ->addItemFilter(ItemFilter::FEATURED_ONLY, array(true))
            ->addItemFilter(ItemFilter::FEEDBACK_SCORE_MAX, array(9))
            ->addItemFilter(ItemFilter::FEEDBACK_SCORE_MIN, array(9))
//            ->addItemFilter(ItemFilter::FREE_SHIPPING_ONLY, array(true))
//            ->addItemFilter(ItemFilter::GET_IT_FAST_ONLY, array(true))
//            ->addItemFilter(ItemFilter::HIDE_DUPLICATE_ITEMS, array(true))
//            ->addItemFilter(ItemFilter::LISTED_IN, array(GlobalId::EBAY_AT))
//            ->addItemFilter(ItemFilter::LISTING_TYPE, array('All', 'AuctionWithBIN'))
//            ->addItemFilter(ItemFilter::LOCAL_PICKUP_ONLY, array(true))
            ->addItemFilter(ItemFilter::LOCAL_SEARCH_ONLY, array(true))
//            ->addItemFilter(ItemFilter::LOCATED_IN, array('dz', 'ai'))
//            ->addItemFilter(ItemFilter::LOTS_ONLY, array(true))
            ->addItemFilter(ItemFilter::MAX_BIDS, array(1))
//            ->addItemFilter(ItemFilter::MAX_HANDLING_TIME, array(1))
            ->addItemFilter(ItemFilter::MAX_DISTANCE, array(6))
//            ->addItemFilter(ItemFilter::MAX_PRICE, array(0.0, Currency::AUSTRALIAN))
//            ->addItemFilter(ItemFilter::MAX_QUANTITY, array(1))
            ->addItemFilter(ItemFilter::MIN_BIDS, array(0))
//            ->addItemFilter(ItemFilter::MIN_PRICE, array(0.1, Currency::AUSTRALIAN))
//            ->addItemFilter(ItemFilter::MIN_QUANTITY, array(1))
//            ->addItemFilter(ItemFilter::MOD_TIME_FROM, array(new \DateTime('1.1.2019')))
//            ->addItemFilter(ItemFilter::OUTLET_SELLER_ONLY, array(false))
//            ->addItemFilter(ItemFilter::PAYMENT_METHOD, array('PayPal'))
//            ->addItemFilter(ItemFilter::RETURNS_ACCEPTED_ONLY, array(false))
//            ->addItemFilter(ItemFilter::SELLER, array('Seller1'))
//            ->addItemFilter(ItemFilter::SELLER_BUSINESS_TYPE, array('Business', 'Ebay-at'))
//            ->addItemFilter(ItemFilter::SOLD_ITEMS_ONLY, array(true))
//            ->addItemFilter(ItemFilter::START_TIME_FROM, array(new \DateTime('1.9.2018')))
//            ->addItemFilter(ItemFilter::START_TIME_TO, array(new \DateTime('1.9.2019')))
            ->addItemFilter(ItemFilter::TOP_RATED_SELLER_ONLY, array(true));
//            ->addItemFilter(ItemFilter::WORLD_OF_GOOD_ONLY, array(false));

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
        die();
    }
}