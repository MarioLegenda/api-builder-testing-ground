<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__.'/../vendor/autoload.php';

use SDKBuilder\SDKBuilder;
use FindingAPI\Core\ItemFilter\ItemFilter;
use FindingAPI\Core\Information\CurrencyInformation;
use Demo\TwigBridge;
use FindingAPI\Core\Information\SortOrder;
use FindingAPI\Core\Information\OutputSelector;
use FindingAPI\Core\Information\ListingType as InformationListingType;

$findingApi = SDKBuilder::inst()
                ->registerApi('finding', __DIR__.'/../tests/finding.yml')
                ->create('finding')
                ->switchOfflineMode(false);

$findingApi
    ->findItemsByKeywords()
    ->setMethod('get')
    ->addKeywords('harry potter')
    ->setPaginationInput(array(
        'entriesPerPage' => 2,
        'pageNumber' => 3,
    ))
    ->setSortOrder(SortOrder::BID_COUNT_FEWEST)
    ->setOutputSelector(array(
        OutputSelector::ASPECT_HISTOGRAM,
        OutputSelector::CATEGORY_HISTOGRAM,
        OutputSelector::CONDITION_HISTOGRAM,
        OutputSelector::PICTURE_URL_LARGE,
        OutputSelector::PICTURE_URL_SUPER_SIZE,
        OutputSelector::SELLER_INFO,
        OutputSelector::STORE_INFO,
        OutputSelector::UNIT_PRICE_INFO,
    ))
    ->addItemFilter(ItemFilter::BEST_OFFER_ONLY, array(true))
    ->addItemFilter(ItemFilter::LISTING_TYPE, array(InformationListingType::AUCTION_WITH_BIN, InformationListingType::STORE_INVENTORY, InformationListingType::AUCTION))
    ->addItemFilter(ItemFilter::CURRENCY, array(CurrencyInformation::AUSTRALIAN));

$response = $findingApi
                ->compile()
                ->send()
                ->getResponse();

$twigBridge = new TwigBridge();

echo $twigBridge->getTwig()->render('index.html.twig', array(
    'response' => $response,
    'processed' => $findingApi->getProcessedRequestString(),
));