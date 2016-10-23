<?php

namespace Test;

require __DIR__.'/../vendor/autoload.php';

use FindingAPI\Core\Information\OperationName;
use FindingAPI\Core\ItemFilter\ItemFilter;
use FindingAPI\Core\Response;
use FindingAPI\Core\ResponseParser\ResponseItem\Child\Item\Item;
use FindingAPI\Core\ResponseParser\ResponseItem\Child\Item\ListingInfo;
use FindingAPI\Core\ResponseParser\ResponseItem\Child\Item\SellerInfo;
use FindingAPI\Core\ResponseParser\ResponseItem\Child\Item\SellingStatus;
use FindingAPI\Core\ResponseParser\ResponseItem\Child\Item\ShippingInfo;
use FindingAPI\Core\ResponseParser\ResponseItem\Child\Item\StoreInfo;
use FindingAPI\Core\ResponseParser\ResponseItem\Child\Item\UnitPrice;
use FindingAPI\Finding;
use FindingAPI\Core\Request;
use FindingAPI\Definition\Definition;
use FindingAPI\Core\ResponseParser\ResponseItem\Child\Item\Condition;
use FindingAPI\Core\ResponseParser\ResponseItem\Child\Item\DiscountPriceInfo;
use FindingAPI\Core\ResponseParser\ResponseItem\Child\Item\Category;
use FindingAPI\Core\Information\Currency as InformationCurrency;

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
        $queries = array(
            'harry potter' => array(
                array (ItemFilter::BEST_OFFER_ONLY, array(true)),
                array (ItemFilter::CURRENCY, array(InformationCurrency::AUSTRALIAN)),
            ),
        );

        foreach ($queries as $query => $filters) {
            $request = new Request();

            $request
                ->setOperationName(OperationName::FIND_ITEMS_BY_KEYWORDS)
                ->setMethod('get')
                ->setResponseDataFormat('xml')
                ->setSecurityAppId('Mariokrl-testing-PRD-ee6e68035-e73c8a53')
                ->setOutputSelector(array('SellerInfo', 'StoreInfo', 'CategoryHistogram', 'AspectHistogram'))
                ->addSearch(Definition::customDefinition($query));

            if ($filters !== null) {
                foreach ($filters as $filter) {
                    $request->addItemFilter($filter[0], $filter[1]);
                }
            }

            $finder = Finding::getInstance($request);

            $processed = $finder->getProcessed();

            $finder->setValidationRule('global-item-filters', true);
            $finder->setValidationRule('individual-item-filters', true);

            $response = $finder->send()->getResponse();

            $this->validateResponse($response);
        }
 //           ->setOperationName(OperationName::FIND_ITEMS_BY_KEYWORDS)
            //->specialFeature()->findLocalItems(31000)
//            ->setBuyerPostalCode(31000)
//            ->setSortOrder(SortOrder::START_TIME_NEWEST)
//            ->setPaginationInput(20, 'pageNumber')
//            ->setOutputSelector(array('SellerInfo', 'StoreInfo'))
            //->addOption(Options::SMART_GUESS_SYSTEM)
/*            ->addSearch(Definition::customDefinition('harry potter'))
            ->addItemFilter(ItemFilter::AUTHORIZED_SELLER_ONLY, array(true))
            ->addItemFilter(ItemFilter::AVAILABLE_TO, array('AF'))
            ->addItemFilter(ItemFilter::BEST_OFFER_ONLY, array(true))
            ->addItemFilter(ItemFilter::CHARITY_ONLY, array(true))
            ->addItemFilter(ItemFilter::CONDITION, array('New', 1000, 1500, 1750))
            ->addItemFilter(ItemFilter::CURRENCY, array(Currency::AUSTRALIAN))
            ->addItemFilter(ItemFilter::END_TIME_FROM, array(new \DateTime('1.1.2018 21:23:38')))
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
            ->addItemFilter(ItemFilter::MAX_PRICE, array(0.0, Currency::AUSTRALIAN))
            ->addItemFilter(ItemFilter::MAX_QUANTITY, array(1))
            ->addItemFilter(ItemFilter::MIN_BIDS, array(0))
            ->addItemFilter(ItemFilter::MIN_PRICE, array(0.1, Currency::AUSTRALIAN))
            ->addItemFilter(ItemFilter::MIN_QUANTITY, array(1))
            ->addItemFilter(ItemFilter::MOD_TIME_FROM, array(new \DateTime('1.1.2019')))
            ->addItemFilter(ItemFilter::OUTLET_SELLER_ONLY, array(false))
            ->addItemFilter(ItemFilter::PAYMENT_METHOD, array('PayPal'))
            ->addItemFilter(ItemFilter::RETURNS_ACCEPTED_ONLY, array(false))
            ->addItemFilter(ItemFilter::SELLER, array('Seller1'))
            ->addItemFilter(ItemFilter::SELLER_BUSINESS_TYPE, array('Business', 'Ebay-at'))
            ->addItemFilter(ItemFilter::SOLD_ITEMS_ONLY, array(true))
            ->addItemFilter(ItemFilter::START_TIME_FROM, array(new \DateTime('1.9.2018')))
            ->addItemFilter(ItemFilter::START_TIME_TO, array(new \DateTime('1.9.2019')))
            ->addItemFilter(ItemFilter::TOP_RATED_SELLER_ONLY, array(true))
            ->addItemFilter(ItemFilter::WORLD_OF_GOOD_ONLY, array(false));*/
    }

    private function validateResponse(Response $response)
    {
        $this->assertInternalType('string', $response->getRoot()->getName(), 'RootItem name should be ebay method name, for instance findItemByKeywordsResponse');
        $this->assertEquals('http://www.ebay.com/marketplace/search/v1/services', $response->getRoot()->getNamespace(), 'Invalid ebay api url, not a string');
        $this->assertInternalType('string', $response->getRoot()->getAck(), 'Invalid ack. Ack should be something like Success');
        $this->assertInternalType('string', $response->getRoot()->getTimestamp(), 'Invalid timestamp. Not a string');
        $this->assertInternalType('string', $response->getRoot()->getVersion(), 'Invalid version. Not a string');
        $this->assertInternalType('int', $response->getRoot()->getSearchResultsCount(), 'Invalid search results count. Not a string');

        $searchResults = $response->getSearchResults();
        foreach ($searchResults as $item) {
            $this->validateItem($item);
        }

        // TODO: Implement ConditionCategoryHistogram later
        //$conditionHistogramContainer = $response->getConditionHistogramContainer();

        //$this->assertInstanceOf(ConditionHistogramContainer::class, $conditionHistogramContainer, 'Response::getConditionHistogramContainer() should return '.ConditionHistogramContainer::class);
    }

    private function validateItem(Item $item)
    {
        $this->assertInstanceOf('FindingAPI\Core\ResponseParser\ResponseItem\Child\Item\Item', $item, 'Invalid Item');

        $this->assertInternalType('string', $item->getItemId(), 'Item::getItemId() should return a string');
        $this->assertInternalType('string', $item->getGlobalId(), 'Item::getGlobalId() should return a string');
        $this->assertInternalType('string', $item->getTitle(), 'Item::getTitle() should return a title');
        $this->assertInternalType('string', $item->getViewItemUrl(), 'Item::getViewItemUrl() should return a string');
        $this->assertInternalType('array', $item->getProductId(), 'Item::getProductId() should return an array');
        $this->assertInternalType('array', $item->getPaymentMethod(), 'Item::getPaymentMethod() should return a string');
        $this->assertInternalType('bool', $item->getReturnsAccepted(), 'Item::getReturnsAccepted() should return bool');
        $this->assertInternalType('bool', $item->getIsMultiVariationListing(), 'Item::getIsMultiVariationListing() should return bool');
        $this->assertInternalType('bool', $item->getTopRatedListing(), 'Item::getTopRatedListing() should return boolean');

        if ($item->getSubtitle() !== null) {
            $this->assertInternalType('string', $item->getSubtitle(), 'Item::getSubtitle() should return a string');
        }

        if ($item->getPictureURLSuperSize() !== null) {
            $this->assertInternalType('string', $item->getPictureURLSuperSize(), 'Item::getPictureURLSuperSize() should return string');
        }

        if ($item->getPictureURLLarge() !== null) {
            $this->assertInternalType('string', $item->getPictureURLLarge(), 'Item::getPictureURLLarge() should return string');
        }

        if ($item->getEekStatus() !== null) {
            $this->assertInternalType('array', $item->getEekStatus(), 'Item::getEekStatus() should return an array');
        }

        if ($item->getDistance() !== null) {
            $this->assertInternalType('string', $item->getDistance(), 'Item::getDistance() should return an array');
        }

        if ($item->getCompatibility() !== null) {
            $this->assertInternalType('string', $item->getCompatibility(), 'Item::getCompatibility() should return a string');
        }

        if ($item->getCharityId() !== null) {
            $this->assertInternalType('string', $item->getCharityId(), 'Item::getCarityId() should return a string');
        }

        if ($item->getAutoPay() !== null) {
            $this->assertInternalType('bool', $item->getAutoPay(), 'Item::getAutoPay() should return a boolean');
        }

        if ($item->getPostalCode() !== null) {
            $this->assertInternalType('int', $item->getPostalCode(), 'Item::getPostalCode() should return an int');
        }

        $this->assertInternalType('string', $item->getLocation(), 'Item::getLocation() should return a string');
        $this->assertInternalType('string', $item->getCountry(), 'Item::getCountry() should return a string');

        if ($item->getGalleryUrl() !== null) {
            $this->assertInternalType('string', $item->getGalleryUrl(), 'Item::getGalleryUrl() should return a string');
        }

        $this->assertInternalType('string', $item->getPrimaryCategory()->getCategoryId(), 'Invalid primary category id. Expected string');
        $this->assertInternalType('string', $item->getPrimaryCategory()->getCategoryName(), 'Invalid primary category name. Expected string');

        $secondaryCategory = $item->getSecondaryCategory();

        if ($secondaryCategory instanceof Category) {
            $this->assertInstanceOf(Category::class, $secondaryCategory, 'Item::getSecondaryCategory() should return an instance of '.Category::class);

            $this->assertInternalType('string', $item->getSecondaryCategory()->getCategoryId(), 'Invalid secondary category id. Expected string');
            $this->assertInternalType('string', $item->getSecondaryCategory()->getCategoryName(), 'Invalid secondary category name. Expected string');
        }

        $shippingInfo = $item->getShippingInfo();

        if ($shippingInfo instanceof ShippingInfo) {
            $this->assertInstanceOf(ShippingInfo::class, $shippingInfo, 'Invalid object. Expected '.ShippingInfo::class);

            if ($shippingInfo->getShippingServiceCost() !== null) {
                $this->assertInternalType('array', $shippingInfo->getShippingServiceCost(), 'Item::getShippingServiceCost() should return an array');
            }

            if ($shippingInfo->getExpeditedShipping() !== null) {
                $this->assertInternalType('bool', $shippingInfo->getExpeditedShipping(), 'ShippingInfo::getExpeditedShipping() has to return bool');
            }

            if ($shippingInfo->getHandlingTime() !== null) {
                $this->assertInternalType('int', $shippingInfo->getHandlingTime(), 'ShippingInfo::getHandlingTime() should return an int');
            }

            if ($shippingInfo->getOneDayShippingAvailable() !== null) {
                $this->assertInternalType('bool', (bool) $shippingInfo->getOneDayShippingAvailable(), 'ShippingInfo::oneDayShippingAvailable() has to return bool');
            }

            if ($shippingInfo->getShippingType() !== null) {
                $this->assertInternalType('string', $shippingInfo->getShippingType(), 'ShippingInfo::shippingType() has to return string');
            }

            if ($shippingInfo->getShipToLocations()) {
                $this->assertInternalType('array', $shippingInfo->getShipToLocations(), 'ShippingInfo::shipToLocations() has to return array');
            }
        }

        $sellingStatus = $item->getSellingStatus();

        if ($sellingStatus instanceof SellingStatus) {
            $this->assertInstanceOf(SellingStatus::class, $sellingStatus, 'Invalid instance. Expected '.SellingStatus::class);

            if ($sellingStatus->getConvertedCurrentPrice() !== null) {
                $this->assertInternalType('array', $sellingStatus->getConvertedCurrentPrice(), 'SellingStatus::getConvertedCurrentPrice() should return an array');
            }

            if ($sellingStatus->getCurrentPrice() !== null) {
                $this->assertInternalType('array', $sellingStatus->getCurrentPrice(), 'SellingStatus::getCurrentPrice() should return an array');
            }

            if ($sellingStatus->getSellingState() !== null) {
                $this->assertInternalType('string', $sellingStatus->getSellingState(), 'SellingStatus::getSellingState() should return a string');
            }

            if ($sellingStatus->getTimeLeft() !== null) {
                $this->assertInternalType('string', $sellingStatus->getTimeLeft(), 'SellingStatus::getTimeLeft() should return a string');
            }
        }

        $listingInfo = $item->getListingInfo();

        if ($listingInfo instanceof ListingInfo) {
            $this->assertInstanceOf(ListingInfo::class, $listingInfo, 'Invalid instance. Expected '.ListingInfo::class);

            if ($listingInfo->getBestOfferEnabled() !== null) {
                $this->assertInternalType('bool', $listingInfo->getBestOfferEnabled(), 'ListingInfo::getBestOfferEnabled() should return a bool');
            }

            if ($listingInfo->getBuyItNowAvailable() !== null) {
                $this->assertInternalType('bool', $listingInfo->getBuyItNowAvailable(), 'ListingInfo::getBuyItNowAvailable() should return a bool');
            }

            if ($listingInfo->getStartTime() !== null) {
                $this->assertInternalType('string', $listingInfo->getStartTime(), 'ListingInfo::getStartTime() should return a string');
            }

            if ($listingInfo->getEndTime() !== null) {
                $this->assertInternalType('string', $listingInfo->getEndTime(), 'ListingInfo::getEndTime() should return a string');
            }

            if ($listingInfo->getListingType() !== null) {
                $this->assertInternalType('string', $listingInfo->getListingType(), 'ListingInfo::getListingType() should return a string');
            }

            if ($listingInfo->getGift() !== null) {
                $this->assertInternalType('bool', $listingInfo->getGift(), 'ListingInfo::getGift() should return a bool');
            }

            if ($listingInfo->getBuyItNowPrice() !== null) {
                $this->assertInternalType('array', $listingInfo->getBuyItNowPrice(), 'ListingInfo::getBuyItNowPrice() should return an array');
            }

            if ($listingInfo->getConvertedBuyItNowPrice() !== null) {
                $this->assertInternalType('array', $listingInfo->getConvertedBuyItNowPrice(), 'ListingInfo::getConvertedBuyItNowPrice() should return an array');
            }
        }

        if ($item->getCondition() instanceof Condition) {
            $condition = $item->getCondition();

            $this->assertInternalType('int', $condition->getConditionId(), 'Condition::getConditionId() should return an int');
            $this->assertInternalType('string', $condition->getConditionDisplayName(), 'Condition::getConditionDisplayName() should return a string');
        }

        if (is_array($item->getAttributes())) {
            $attributes = $item->getAttributes();

            foreach ($attributes as $attribute) {
                $this->assertInstanceOf('FindingAPI\Core\ResponseParser\ResponseItem\Child\Item\Attribute', $attribute, 'Unknown instance. Expected Attribute');

                $this->assertInternalType('string', $attribute->getAttributeName(), 'Attribute::getAttributeName() should return a string');
                $this->assertInternalType('string', $attribute->getAttributeValue(), 'Attribute::getAttributeValue() should return a string');
            }
        }

        if ($item->getDiscountPriceInfo() instanceof DiscountPriceInfo) {
            $discountPriceInfo = $item->getDiscountPriceInfo();

            $this->assertInternalType('array', $discountPriceInfo->getOriginalRetailPrice(), 'DiscountPriceInfo::getOriginalRetailPrice() should return an array');
        }

        $galleryInfoContainer = $item->getGalleryContainer();

        if ($galleryInfoContainer !== null) {
            foreach ($galleryInfoContainer as $galleryContainer) {
                $this->assertInternalType('string', $galleryContainer->getUrl(), 'GalleryUrl::getUrl() should return a string');
                $this->assertInternalType('string', $galleryContainer->getSize(), 'GalleryUrl::getSize() should return a string');
            }
        }

        $galleryPlusPictureUrls = $item->getGalleryPlusPictureURL();

        if ($galleryPlusPictureUrls !== null) {
            $this->assertInternalType('array', $galleryPlusPictureUrls, 'Item::getGalleryPlusPictureUrl() should return an array');

            foreach ($galleryPlusPictureUrls as $url) {
                $this->assertInternalType('string', $url, 'Item::getGalleryPlusPictureURL() should return an array with string urls');
            }
        }

        $sellerInfo = $item->getSellerInfo('sellerInfo');

        if ($sellerInfo instanceof SellerInfo) {
            $this->assertInstanceOf(SellerInfo::class, $sellerInfo, 'Item::getSellerInfo() should return an instance of '.SellerInfo::class);

            if ($sellerInfo->getFeedbackRatingStar() !== null) {
                $this->assertInternalType('string', $sellerInfo->getFeedbackRatingStar(), 'SellerInfo::getFeedbackRatingStar() should return a string');
            }

            if ($sellerInfo->getFeedbackScore() !== null) {
                $this->assertInternalType('int', $sellerInfo->getFeedbackScore(), 'SellerInfo::getFeedbackScore() should reteurn an int');
            }

            if ($sellerInfo->getPositiveFeedbackPercent() !== null) {
                $this->assertInternalType('float', $sellerInfo->getPositiveFeedbackPercent(), 'SellerInfo::getPositiveFeedbackPercent() should return a float');
            }

            if ($sellerInfo->getSellerUsername() !== null) {
                $this->assertInternalType('string', $sellerInfo->getSellerUsername(), 'SellerInfo::getSellerUsername() should return a string');
            }

            if ($sellerInfo->getTopRatedSeller() !== null) {
                $this->assertInternalType('bool', $sellerInfo->getTopRatedSeller(), 'SellerInfo::getTopRatedSeller() should return a boolean');
            }
        }

        $storeInfo = $item->getStoreInfo('storeInfo');

        if ($storeInfo instanceof StoreInfo) {
            $this->assertInstanceOf(StoreInfo::class, $storeInfo, 'Item::getStoreInfo() should return an instance of '.StoreInfo::class);

            $this->assertInternalType('string', $storeInfo->getStoreName(), 'StoreInfo::getStoreName() should return a string');
            $this->assertInternalType('string', $storeInfo->getStoreURL(), 'StoreInfo::getStoreURL() should return a string');
        }

        $unitPrice = $item->getUnitPrice('unitPrice');

        if ($unitPrice instanceof UnitPrice) {
            $this->assertInstanceOf($unitPrice, UnitPrice::class, 'Item::getUnitPrice() should return an instance of '.UnitPrice::class);

            $this->assertInternalType('float', $unitPrice->getQuantity(), 'UnitPrice::getQuantity() should return a float');
            $this->assertInternalType('string', $unitPrice->getType(), 'UnitPrice::getType() should return a string');
        }
    }
}