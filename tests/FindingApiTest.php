<?php

namespace Test;

require __DIR__ . '/../vendor/autoload.php';

use FindingAPI\Core\Response\ResponseProxy;
use SDKBuilder\SDKBuilder;
use FindingAPI\Core\ItemFilter\ItemFilter;
use SDKBuilder\Request\Method\Method;
use FindingAPI\Core\Information\CurrencyInformation;
use FindingAPI\Core\ResponseParser\ResponseItem\AspectHistogramContainer;
use FindingAPI\Core\ResponseParser\ResponseItem\CategoryHistogramContainer;
use FindingAPI\Core\ResponseParser\ResponseItem\Child\Aspect\Aspect;
use FindingAPI\Core\ResponseParser\ResponseItem\Child\Aspect\ValueHistogram;
use FindingAPI\Core\ResponseParser\ResponseItem\Child\CategoryHistogram\CategoryHistogram;
use FindingAPI\Core\ResponseParser\ResponseItem\Child\Error\ErrorMessage;
use FindingAPI\Core\ResponseParser\ResponseItem\Child\Item\GalleryInfoContainer;
use FindingAPI\Core\ResponseParser\ResponseItem\Child\Item\Item;
use FindingAPI\Core\ResponseParser\ResponseItem\Child\Item\ListingInfo;
use FindingAPI\Core\ResponseParser\ResponseItem\Child\Item\SellerInfo;
use FindingAPI\Core\ResponseParser\ResponseItem\Child\Item\SellingStatus;
use FindingAPI\Core\ResponseParser\ResponseItem\Child\Item\ShippingInfo;
use FindingAPI\Core\ResponseParser\ResponseItem\Child\Item\StoreInfo;
use FindingAPI\Core\ResponseParser\ResponseItem\Child\Item\UnitPrice;
use FindingAPI\Core\ResponseParser\ResponseItem\ErrorContainer;
use FindingAPI\Core\ResponseParser\ResponseItem\PaginationOutput;
use FindingAPI\Core\ResponseParser\ResponseItem\SearchResultsContainer;
use FindingAPI\Core\ResponseParser\ResponseItem\Child\Item\Condition;
use FindingAPI\Core\ResponseParser\ResponseItem\Child\Item\DiscountPriceInfo;
use FindingAPI\Core\ResponseParser\ResponseItem\Child\Item\Category;
use FindingAPI\Core\ResponseParser\ResponseItem\ConditionHistogramContainer;
use FindingAPI\Core\Response\ResponseInterface;
use SDKBuilder\Request\Parameter;

class FindingApiTest extends \PHPUnit_Framework_TestCase
{
    public function testInjectableParameters()
    {
        SDKBuilder::inst()->registerApi('finding', __DIR__.'/finding.yml');

        $method = new Method('new_request_method', array(
            'name' => 'newRequestMethod',
            'object' => 'Test\\Method\\NewRequestMethod',
            'methods' => array('newParameter'),
        ));

        $newParameter = new Parameter('new_parameter', array(
            'representation' => 'newParameter',
            'value' => 6,
            'type' => array('optional'),
            'valid' => null,
            'deprecated' => false,
            'obsolete' => false,
            'throws_exception_if_deprecated' => false,
            'error_message' => 'Invalid value for %s and represented as %s',
        ));

        $findingApi = SDKBuilder::inst()->create('finding')->switchOfflineMode(true);

        $findingApi
            ->addParameter('special_parameter', $newParameter)
            ->addMethod($method);

        $findingApi->newRequestMethod()->setNewParameter('kreten');
    }

    public function testItemFilters()
    {
        $findingApi = SDKBuilder::inst()->create('finding');

        $request = $findingApi->findItemsByKeywords();

        $request->addKeywords('constantine');

        $itemFilterStorage = $request->getDynamicStorage();

        // single value item filter
        $itemFilterStorage->addDynamic(array(
            'name' => 'SingleValueItemFilter',
            'object' => 'Test\ItemFilter\SingleValueItemFilter',
            'value' => null,
            'multiple_values' => false,
            'date_time' => false,
        ));

        $this->assertTrue($itemFilterStorage->hasDynamic('SingleValueItemFilter'));

        $itemFilterStorage->removeDynamic('SingleValueItemFilter');

        $this->assertFalse($itemFilterStorage->hasDynamic('SingleValueItemFilter'));

        // multiple value item filter

        $itemFilterStorage->addDynamic(array(
            'name' => 'MultipleValueItemFilter',
            'object' => 'Test\ItemFilter\MultipleValueItemFilter',
            'value' => null,
            'multiple_values' => true,
            'date_time' => false,
        ));
    }

    public function testSingletonApi()
    {
        $findingApiFirst = SDKBuilder::inst()->create('finding');

        $findingApiFirst->getVersion();

        $versionResponse = $findingApiFirst
            ->compile()
            ->send()
            ->getResponse();

        $this->validateXmlResponse($versionResponse);

        $findingApiSecond = SDKBuilder::inst()->create('finding');

        $findingApiSecond
            ->getHistograms()
            ->setCategoryId(23);

        $histogramResponse = $findingApiSecond
            ->compile()
            ->send()
            ->getResponse();

        $this->validateXmlResponse($histogramResponse);

        if ($findingApiFirst->getResponse() !== $findingApiSecond->getResponse()) {
            $this->fail('Every created api should create a new '.ResponseProxy::class.' every time a request is sent');
        }

        $this->assertInstanceOf(ResponseProxy::class, $versionResponse, '$versionResponse should be an instance of '.ResponseProxy::class);
        $this->assertInstanceOf(ResponseProxy::class, $histogramResponse, '$histogramResponse should be an instance of '.ResponseProxy::class);

        $histogramRawResponse = $histogramResponse->getRawResponse();
        $versionRawResponse = $versionResponse->getRawResponse();

        $this->assertXmlStringNotEqualsXmlString($histogramRawResponse, $versionRawResponse, 'Version raw response and histogram raw response cannot be equal');

        if ($findingApiFirst !== $findingApiSecond) {
            $this->fail('testSingeltonApi() $findingApiFirst and $findingApiSecond should be same references');
        }

        $findingApiThird = SDKBuilder::inst()->create('finding');

        $versionResponse = $findingApiThird
            ->compile()
            ->send()
            ->getResponse();

        $this->validateXmlResponse($versionResponse);

        $findingApiThirdVersionRawResponse = $versionResponse->getRawResponse();

        $findingApiThird->restoreDefaults();

        $findingApiSecond
            ->getHistograms()
            ->setCategoryId(23);

        $histogramResponse = $findingApiSecond
            ->compile()
            ->send()
            ->getResponse();

        $this->validateXmlResponse($histogramResponse);

        $findingApiThirdHistogramRawResponse = $histogramResponse->getRawResponse();

        $this->assertXmlStringNotEqualsXmlString(
            $findingApiThirdVersionRawResponse,
            $findingApiThirdHistogramRawResponse,
            '$findingApiThird raw responses should not be equal'
        );
    }

    public function testGetVersion()
    {
        $findingApi = SDKBuilder::inst()->create('finding');

        $findingApi->getVersion();

        $response = $findingApi
            ->compile()
            ->send()
            ->getResponse();

        $this->validateXmlResponse($response);
    }

    public function testHistograms()
    {
        $findingApi = SDKBuilder::inst()->create('finding');

        $findingApi
            ->getHistograms()
            ->setCategoryId(23);

        $response = $findingApi
            ->compile()
            ->send()
            ->getResponse();

        $this->validateXmlResponse($response);
    }

    public function testGetSearchKeywordsRecommendations()
    {
        $findingApi = SDKBuilder::inst()->create('finding');

        $findingApi
            ->getSearchKeywordsRecommendation()
            ->addKeywords('football');

        $response = $findingApi
            ->compile()
            ->send()
            ->getResponse();

        $this->validateXmlResponse($response);
    }

    public function testFindItemsByProduct()
    {
        $findingApi = SDKBuilder::inst()->create('finding');

        $findingApi
            ->findItemsByProduct()
            ->setProductIdType('ReferenceID')
            ->setProductId(53039031);

        $findingApi
            ->compile()
            ->send();

        $this->validateXmlResponse($findingApi->getResponse());
    }

    public function testFindItemsByCategoryRequest()
    {
        $findingApi = SDKBuilder::inst()->create('finding');

        $findingApi
            ->findItemsByCategory()
            ->setCategoryId(23);

        $this->validateXmlResponse($findingApi->compile()->send()->getResponse());
    }

    public function testFindItemsAdvancedRequest()
    {
        $findingApi = SDKBuilder::inst()->create('finding');

        $findingApi
            ->findItemsAdvanced()
            ->setOutputSelector(array('SellerInfo', 'StoreInfo', 'CategoryHistogram', 'AspectHistogram'))
            ->setCategoryId(23)
            ->addKeywords('baseball')
            ->enableDescriptionSearch()
            ->setResponseFormat('xml');

        $response = $findingApi
            ->compile()
            ->send()
            ->getResponse();

        $this->validateXmlResponse($response);
    }

    public function testFindCompletedItemsRequest()
    {
        $findingApi = SDKBuilder::inst()->create('finding');

        $findingApi
            ->findCompletedItems()
            ->setCategoryId(23)
            ->addKeywords('baseball');

        $this->validateXmlResponse($findingApi->compile()->send()->getResponse());
    }

    public function testFindItemsByKeywordsJsonRequest()
    {
        $findingApi = SDKBuilder::inst()->create('finding');

        $findingApi
            ->findItemsByKeywords()
            ->setMethod('get')
            ->addKeywords('call of duty')
            ->setOutputSelector(array('SellerInfo', 'StoreInfo', 'CategoryHistogram', 'AspectHistogram'))
            ->addDynamic(ItemFilter::BEST_OFFER_ONLY, array(true))
            ->addDynamic(ItemFilter::CURRENCY, array(CurrencyInformation::AUSTRALIAN))
            ->setResponseFormat('json');

        $dynamics = $findingApi->getRequest()->getDynamicStorage();

        $this->assertTrue($dynamics->isDynamicInRequest(ItemFilter::BEST_OFFER_ONLY), 'BEST_OFFER_ONLY should be set as a dynamic');
        $this->assertTrue($dynamics->isDynamicInRequest(ItemFilter::CURRENCY), 'CURRENCY should be set as a dynamic');

        $response = $findingApi
            ->compile()
            ->send()
            ->getResponse();

        $this->validateJsonResponse($response);
    }

    public function testFindItemsByKeywordsRequest()
    {
        $queries = array(
            'harry potter' => array(
                array (ItemFilter::BEST_OFFER_ONLY, array(true)),
                array (ItemFilter::CURRENCY, array(CurrencyInformation::AUSTRALIAN)),
            ),
        );

        foreach ($queries as $query => $filters) {
            $findingApi = SDKBuilder::inst()->create('finding');

            $request = $findingApi->findItemsByKeywords();

            $request
                ->setOutputSelector(array(
                    'SellerInfo',
                    'StoreInfo',
                    'AspectHistogram',
                    'CategoryHistogram',
                    'GalleryInfo',
                    'PictureURLLarge',
                    'PictureURLSuperSize',
                    'UnitPriceInfo',
                ))
                ->addKeywords($query)
                ->setMethod('get');

            if ($filters !== null) {
                foreach ($filters as $filter) {
                    $request->addDynamic($filter[0], $filter[1]);
                }
            }

            $response = $findingApi
                ->compile()
                ->send()
                ->getResponse();


            //var_dump($processed);

            //var_dump((string) $response->getGuzzleResponse()->getBody());
            $this->validateXmlResponse($response);
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

    public function validateJsonResponse(ResponseInterface $response)
    {
        $jsonArray = $response->toArray()['response'];

        $rootItem = $jsonArray['rootItem'];

        $this->assertInternalType('string', $rootItem['ack']);
        $this->assertInternalType('string', $rootItem['namespace']);
        $this->assertInternalType('int', $rootItem['searchResultsCount']);
        $this->assertInternalType('string', $rootItem['version']);
        $this->assertInternalType('string', $rootItem['timestamp']);

        if (array_key_exists('errors', $jsonArray)) {
            $errors = $jsonArray['errors'];

            if (is_array($errors)) {
                foreach ($errors as $error) {
                    $this->assertInternalType('string', $error['subdomain']);
                    $this->assertInternalType('string', $error['severity']);
                    $this->assertInternalType('string', $error['message']);

                    if (array_key_exists('exceptionId', $error)) {
                        $this->assertInternalType('string', $error['exceptionId']);
                    }

                    $this->assertInternalType('int', $error['errorId']);
                    $this->assertInternalType('string', $error['domain']);
                    $this->assertInternalType('string', $error['category']);
                }

                throw new \Exception('The response validated but Ebay Finding api response was an error');
            }
        }

        $paginationOutput = $jsonArray['paginationOutput'];

        $this->assertInternalType('int', $paginationOutput['entriesPerPage']);
        $this->assertInternalType('int', $paginationOutput['pageNumber']);
        $this->assertInternalType('int', $paginationOutput['totalEntries']);
        $this->assertInternalType('int', $paginationOutput['totalPages']);

        $aspectHistogramContainer = $jsonArray['aspectHistogramContainer'];

        if (!empty($aspectHistogramContainer)) {
            $this->assertInternalType('string', $aspectHistogramContainer['domainDisplayName']);

            foreach ($aspectHistogramContainer['aspects'] as $aspect) {
                $this->assertInternalType('string', $aspect['aspectName']);

                $valueHistograms = $aspect['valueHistograms'];

                if (!empty($valueHistograms)) {
                    foreach ($valueHistograms as $valueHistogram) {
                        $this->assertInternalType('string', $valueHistogram['valueName']);
                        $this->assertInternalType('int', $valueHistogram['count']);
                    }
                }
            }
        }

        $conditionHistogramContainer = $jsonArray['conditionHistogramContainer'];

        if (!empty($conditionHistogramContainer)) {
            foreach ($conditionHistogramContainer as $conditionHistogram) {
                $this->assertInternalType('string', $conditionHistogram['conditionDisplayName']);
                $this->assertInternalType('int', $conditionHistogram['conditionId']);
                $this->assertInternalType('int', $conditionHistogram['count']);
            }
        }

        $categoryHistogramContainer = $jsonArray['categoryHistogramContainer'];

        if (!empty($categoryHistogramContainer)) {
            foreach ($categoryHistogramContainer as $categoryHistogram) {
                $this->assertInternalType('string', $categoryHistogram['categoryId']);
                $this->assertInternalType('string', $categoryHistogram['categoryName']);
                $this->assertInternalType('int', $categoryHistogram['count']);
            }
        }

        $searchResults = $jsonArray['searchResultsContainer'];

        if (!empty($searchResults)) {
            foreach ($searchResults as $searchResult) {
                $validKeys = array(
                    'itemId',
                    'title',
                    'subtitle',
                    'storeInfo',
                    'unitPrice',
                    'sellerInfo',
                    'pictureUrlSuperSize',
                    'galleryPlusPictureUrl',
                    'pictureUrlLarge',
                    'galleryInfoContainer',
                    'eekStatus',
                    'distance',
                    'discountPriceInfo',
                    'compatibility',
                    'charityId',
                    'primaryCategory',
                    'secondaryCategory',
                    'condition',
                    'topRatedListing',
                    'multiVariationListing',
                    'returnsAccepted',
                    'listingInfo',
                    'sellingStatus',
                    'shippingInfo',
                    'country',
                    'location',
                    'postalCode',
                    'autoPay',
                    'paymentMethods',
                    'productId',
                    'viewItemUrl',
                    'galleryUrl',
                    'globalId',
                );

                foreach ($validKeys as $validKey) {
                    $this->assertArrayHasKey($validKey, $searchResult, 'Key '.$validKey.' not found in search result in json response');
                }

                $this->assertInternalType('string', $searchResult['title']);

                if (!is_null($searchResult['subtitle'])) {
                    $this->assertInternalType('string', $searchResult['subtitle']);
                }

                $this->assertInternalType('string', $searchResult['itemId']);

                if (array_key_exists('unitPrice', $searchResult)) {
                    $unitPrice = $searchResult['unitPrice'];

                    if (is_array($unitPrice)) {
                        $this->assertInternalType('float', $unitPrice['quantity']);
                        $this->assertInternalType('string', $unitPrice['type']);
                    }
                }

                if (!empty($searchResult['storeInfo'])) {
                    $storeInfo = $searchResult['storeInfo'];

                    $this->assertInternalType('string', $storeInfo['storeName']);
                    $this->assertInternalType('string', $storeInfo['storeUrl']);
                }

                if (!empty($searchResult['sellerInfo'])) {
                    $sellerInfo = $searchResult['sellerInfo'];

                    $this->assertInternalType('string', $sellerInfo['feedbackRatingStar']);
                    $this->assertInternalType('int', $sellerInfo['feedbackScore']);
                    $this->assertInternalType('float', $sellerInfo['positiveFeedbackPercent']);
                    $this->assertInternalType('string', $sellerInfo['sellerUsername']);
                    $this->assertInternalType('bool', $sellerInfo['topRatedSeller']);
                }

                if (!is_null($searchResult['pictureUrlLarge'])) {
                    $this->assertInternalType('string', $searchResult['pictureUrlLarge']);
                }

                if (!is_null($searchResult['pictureUrlSuperSize'])) {
                    $this->assertInternalType('string', $searchResult['pictureUrlSuperSize']);
                }

                if (!is_null($searchResult['galleryPlusPictureUrl'])) {
                    $this->assertInternalType('string', $searchResult['galleryPlusPictureUrl']);
                }

                if (!empty($searchResult['galleryInfoContainer'])) {
                    foreach ($searchResult['galleryInfoContainer'] as $gallery) {
                        $this->assertInternalType('string', $gallery['size']);
                        $this->assertInternalType('url', $gallery['url']);
                    }
                }

                if (!empty($searchResult['eekStatus'])) {
                    foreach ($searchResult['eekStatus'] as $eekStatus) {
                        $this->assertInternalType('string', $eekStatus);
                    }
                }

                if (!empty($searchResult['distance'])) {
                    $distance = $searchResult['distance'];

                    $this->assertInternalType('float', $distance['distance']);
                    $this->assertInternalType('string', $distance['unit']);
                }

                if (!empty($searchResult['discountPriceInfo'])) {
                    $discountPriceInfo = $searchResult['discountPriceInfo'];

                    if (is_array($discountPriceInfo['originalRetailPrice'])) {
                        $originalRetailPrice = $discountPriceInfo['originalRetailPrice'];

                        $this->assertInternalType('string', $originalRetailPrice['currencyId']);
                        $this->assertInternalType('float', $originalRetailPrice['amount']);
                    }

                    $this->assertInternalType('string', $discountPriceInfo['minimumAdvertisedPriceExposure']);
                    $this->assertInternalType('string', $discountPriceInfo['pricingTreatment']);

                    if (!empty($discountPriceInfo['soldOnEbay'])) {
                        $this->assertInternalType('bool', $discountPriceInfo['soldOnEbay']);
                    }

                    if (!empty($discountPriceInfo['soldOffEbay'])) {
                        $this->assertInternalType('bool', $discountPriceInfo['soldOffEbay']);
                    }
                }

                if (!empty($searchResult['compatibility'])) {
                    $this->assertInternalType('string', $searchResult['compatibility']);
                }

                if (!empty($searchResult['charityId'])) {
                    $this->assertInternalType('string', $searchResult['charityId']);
                }

                if (!empty($searchResult['attributes'])) {
                    $attributes = $searchResult['attributes'];

                    foreach ($attributes as $attribute) {
                        $this->assertInternalType('string', $attribute['attributeName']);
                        $this->assertInternalType('string', $attribute['attributeValue']);
                    }
                }

                if (!empty($searchResult['condition'])) {
                    $condition = $searchResult['condition'];

                    $this->assertInternalType('int', $condition['conditionId']);

                    if (!is_null($condition['conditionDisplayName'])) {
                        $this->assertInternalType('string', $condition['conditionDisplayName']);
                    }
                }

                $this->assertInternalType('bool', $searchResult['topRatedListing']);
                $this->assertInternalType('bool', $searchResult['multiVariationListing']);
                $this->assertInternalType('bool', $searchResult['returnsAccepted']);

                if (!empty($searchResult['listingInfo'])) {
                    $listingInfo = $searchResult['listingInfo'];

                    $this->assertInternalType('bool', $listingInfo['bestOfferEnabled']);
                    $this->assertInternalType('bool', $listingInfo['buyItNowAvailable']);
                    $this->assertInternalType('bool', $listingInfo['gift']);

                    $buyItNowPrice = $listingInfo['buyItNowPrice'];

                    if (!empty($buyItNowPrice)) {
                        $this->assertInternalType('string', $buyItNowPrice['currencyId']);
                        $this->assertInternalType('float', $buyItNowPrice['amount']);
                    }

                    $convertedBuyItNowPrice = $listingInfo['convertedBuyItNowPrice'];

                    if (!empty($convertedBuyItNowPrice)) {
                        $this->assertInternalType('string', $convertedBuyItNowPrice['currencyId']);
                        $this->assertInternalType('float', $convertedBuyItNowPrice['amount']);
                    }

                    $this->assertInternalType('string', $listingInfo['endTime']);
                    $this->assertInternalType('string', $listingInfo['startTime']);
                    $this->assertInternalType('string', $listingInfo['listingType']);
                }

                if (!empty($searchResult['sellingStatus'])) {
                    $sellingStatus = $searchResult['sellingStatus'];

                    if (!empty($sellingStatus['bidCount'])) {
                        $this->assertInternalType('int', $sellingStatus['bidCount']);
                    }

                    $convertedCurrentPrice = $sellingStatus['convertedCurrentPrice'];

                    if (!empty($convertedCurrentPrice)) {
                        $this->assertInternalType('string', $convertedCurrentPrice['currencyId']);
                        $this->assertInternalType('float', $convertedCurrentPrice['convertedCurrentPrice']);
                    }

                    $currentPrice = $sellingStatus['currentPrice'];

                    if (!empty($currentPrice)) {
                        $this->assertInternalType('string', $currentPrice['currencyId']);
                        $this->assertInternalType('float', $currentPrice['currentPrice']);
                    }

                    $this->assertInternalType('string', $sellingStatus['sellingState']);
                    $this->assertInternalType('string', $sellingStatus['timeLeft']);
                }

                if (!empty($searchResult['shippingInfo'])) {
                    $shippingInfo = $searchResult['shippingInfo'];

                    $shippingServiceCost = $shippingInfo['shippingServiceCost'];

                    if (!empty($shippingServiceCost)) {
                        $this->assertInternalType('string', $shippingServiceCost['currencyId']);
                        $this->assertInternalType('float', $shippingServiceCost['amount']);
                    }

                    $this->assertInternalType('bool', $shippingInfo['expeditedShipping']);

                    if (!empty($shippingInfo['handlingTime'])) {
                        $this->assertInternalType('int', $shippingInfo['handlingTime']);
                    }

                    if (!empty($shippingInfo['oneDayShippingAvailable'])) {
                        $this->assertInternalType('bool', (bool) $shippingInfo['oneDayShippingAvailable']);
                    }

                    $this->assertInternalType('string', $shippingInfo['shippingType']);

                    $shipToLocations = $shippingInfo['shipToLocations'];

                    if (!empty($shipToLocations)) {
                        foreach ($shipToLocations as $location) {
                            $this->assertInternalType('string', $location);
                        }
                    }
                }

                $this->assertInternalType('string', $searchResult['country']);
                $this->assertInternalType('string', $searchResult['location']);

                if (!empty($searchResult['postalCode'])) {
                    $this->assertInternalType('int', $searchResult['postalCode']);
                }

                $this->assertInternalType('bool', $searchResult['autoPay']);

                $paymentMethods = $searchResult['paymentMethods'];

                if (is_array($paginationOutput)) {
                    foreach ($paymentMethods as $paymentMethod) {
                        $this->assertInternalType('string', $paymentMethod);
                    }
                }

                $productId = $searchResult['productId'];

                if (!empty($productId)) {
                    $this->assertInternalType('string', $productId['type']);
                    $this->assertInternalType('int', $productId['productId']);
                }

                $this->assertInternalType('string', $searchResult['viewItemUrl']);

                if (!empty($searchResult['galleryUrl'])) {
                    $this->assertInternalType('string', $searchResult['galleryUrl']);
                    $this->assertInternalType('string', $searchResult['globalId']);
                }
            }
        }
    }

    private function validateXmlResponse(ResponseInterface $response)
    {
        $this->assertInternalType('string', $response->getRoot()->getName(), 'RootItem name should be ebay method name, for instance findItemByKeywordsResponse');
        $this->assertEquals('http://www.ebay.com/marketplace/search/v1/services', $response->getRoot()->getNamespace(), 'Invalid ebay api url, not a string');
        $this->assertInternalType('string', $response->getRoot()->getAck(), 'Invalid ack. Ack should be something like Success');
        $this->assertInternalType('string', $response->getRoot()->getTimestamp(), 'Invalid timestamp. Not a string');
        $this->assertInternalType('string', $response->getRoot()->getVersion(), 'Invalid version. Not a string');
        $this->assertInternalType('int', $response->getRoot()->getSearchResultsCount(), 'Invalid search results count. Not a string');

        if ($response->isErrorResponse()) {
            $errors = $response->getErrors();

            $this->assertInstanceOf(ErrorContainer::class, $errors, 'Response::getErrors() has to return an instance of '.ErrorContainer::class);

            foreach ($response->getErrors() as $errorMessage) {
                $this->assertInstanceOf(ErrorMessage::class, $errorMessage, 'When foreach-ing error messages, value has to be an instance of '.ErrorMessage::class);

                $this->assertInternalType('string', $errorMessage->getSubdomain(), 'ErrorMessage::getSubdomain() has to return a string');
                $this->assertInternalType('string', $errorMessage->getSeverity(), 'ErrorMessage::getSeverity() has to return a string');
                $this->assertInternalType('string', $errorMessage->getMessage(), 'ErrorMessage::getMessage() has to return a string');

                if ($errorMessage->getExceptionId() !== null) {
                    $this->assertInternalType('string', $errorMessage->getExceptionId(), 'ErrorMessage::getExceptionId() has to return a string');
                }

                $this->assertInternalType('int', $errorMessage->getErrorId(), 'ErrorMessage::getErrorId() has to return an int');
                $this->assertInternalType('string', $errorMessage->getDomain(), 'ErrorMessage::getDomain() has to return an string');
                $this->assertInternalType('string', $errorMessage->getCategory(), 'ErrorMessage::getDomain() has to return an string');
            }
        }

        $categoryHistogramContainer = $response->getCategoryHistogramContainer();

        if ($categoryHistogramContainer instanceof CategoryHistogramContainer) {
            $this->assertInstanceOf(CategoryHistogramContainer::class, $categoryHistogramContainer, 'Response::getCategoryHistogramContainer() has to return an instance of '.CategoryHistogramContainer::class);

            foreach ($categoryHistogramContainer as $histogram) {
                $this->assertInstanceOf(CategoryHistogram::class, $histogram, 'When foreach-ing a CategoryHistogramContainer, foreach should receive a '.CategoryHistogram::class);

                $this->assertInternalType('string', $histogram->getCategoryId(), 'CategoryHistogram::getCategoryId() should return a string');
                $this->assertInternalType('string', $histogram->getCategoryName(), 'CategoryHistogram::getCategoryName() should return a string');
                $this->assertInternalType('int', $histogram->getCount(), 'CategoryHistogram::getCount() should return a string');

                foreach ($histogram as $childHistogram) {
                    $this->assertInstanceOf(CategoryHistogram::class, $childHistogram, 'When foreach-ing a CategoryHistogramContainer, foreach should receive a '.CategoryHistogram::class);

                    $this->assertInternalType('string', $histogram->getCategoryId(), 'Child CategoryHistogram::getCategoryId() should return a string');
                    $this->assertInternalType('string', $histogram->getCategoryName(), 'Child CategoryHistogram::getCategoryName() should return a string');
                    $this->assertInternalType('int', $histogram->getCount(), 'Child CategoryHistogram::getCount() should return a string');
                }
            }
        }

        $paginationOutput = $response->getPaginationOutput();

        if ($paginationOutput instanceof PaginationOutput) {
            $this->assertInternalType('int', $paginationOutput->getEntriesPerPage(), 'PaginationOutput::getEntriesPerPage() should return an int');
            $this->assertInternalType('int', $paginationOutput->getPageNumber(), 'PaginationOutput::getPageNumber() should return an int');
            $this->assertInternalType('int', $paginationOutput->getTotalEntries(), 'PaginationOutput::getTotalEntries() should return an int');
            $this->assertInternalType('int', $paginationOutput->getTotalPages(), 'PaginationOutput::getTotalPages() should return an int');
        }

        $searchResults = $response->getSearchResults();

        if ($searchResults instanceof SearchResultsContainer) {
            foreach ($searchResults as $item) {
                $this->validateItem($item);
            }
        }

        $aspectHistogram = $response->getAspectHistogramContainer();

        if ($aspectHistogram instanceof AspectHistogramContainer) {
            $this->assertInstanceOf(AspectHistogramContainer::class, $aspectHistogram, 'Response::getAspectHistogramContainer() should return an instance of '.AspectHistogramContainer::class);

            foreach ($aspectHistogram as $aspect) {
                $this->assertInstanceOf(Aspect::class, $aspect, 'When foreach-ing AspectHistogramContainer, every iteration should have '.Aspect::class);

                if ($aspect->getAspectName() !== null) {
                    $this->assertInternalType('string', $aspect->getAspectName(), 'Aspect::getAspectName() should return a string');
                }

                foreach ($aspect as $valueHistogram) {
                    $this->assertInstanceOf(ValueHistogram::class, '', 'When foreach-ing Aspect, every interation should return a ValueHistogram');

                    $this->assertInternalType('string', $valueHistogram->getValueName());
                    $this->assertInternalType('int', $valueHistogram->getCount());
                }
            }
        }

        // TODO: Implement ConditionCategoryHistogram later
        $conditionHistogramContainer = $response->getConditionHistogramContainer();

        if ($conditionHistogramContainer instanceof ConditionHistogramContainer) {
            $this->assertInstanceOf(ConditionHistogramContainer::class, $conditionHistogramContainer, 'Response::getConditionHistogramContainer() should return '.ConditionHistogramContainer::class);

            foreach ($conditionHistogramContainer as $conditionHistogram) {
                $this->assertInternalType('string', $conditionHistogram->getConditionDisplayName('conditionDisplayName'), 'ConditionHistogram::getConditionDisplayName() should return a string');
                $this->assertInternalType('string', $conditionHistogram->getConditionId(), 'ConditionHistogram::getConditionId() has to be of type string');
                $this->assertInternalType('int', $conditionHistogram->getCount(), 'ConditionHistogram::getCount() should be an integer');
            }
        }
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
            $this->assertInternalType('string', $condition->getConditionDisplayName('conditionDisplayName'), 'Condition::getConditionDisplayName() should return a string');
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

        if ($galleryInfoContainer instanceof GalleryInfoContainer) {
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