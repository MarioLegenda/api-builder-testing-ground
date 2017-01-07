<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__.'/../vendor/autoload.php';

use SDKBuilder\SDKBuilder;
use FindingAPI\Core\ItemFilter\ItemFilter;
use FindingAPI\Core\Information\CurrencyInformation;
use Demo\TwigBridge;
use FindingAPI\Core\Information\OutputSelectorInformation;
use FindingAPI\Core\Information\ListingTypeInformation;
use FindingAPI\Core\Information\SortOrderInformation;

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
    ->setSortOrder(SortOrderInformation::BID_COUNT_FEWEST)
    ->setOutputSelector(array(
        OutputSelectorInformation::ASPECT_HISTOGRAM,
        OutputSelectorInformation::CATEGORY_HISTOGRAM,
        OutputSelectorInformation::CONDITION_HISTOGRAM,
        OutputSelectorInformation::PICTURE_URL_LARGE,
        OutputSelectorInformation::PICTURE_URL_SUPER_SIZE,
        OutputSelectorInformation::SELLER_INFO,
        OutputSelectorInformation::STORE_INFO,
        OutputSelectorInformation::UNIT_PRICE_INFO,
    ))
    ->addItemFilter(ItemFilter::BEST_OFFER_ONLY, array(true))
    ->addItemFilter(ItemFilter::LISTING_TYPE, array(ListingTypeInformation::AUCTION_WITH_BIN, ListingTypeInformation::STORE_INVENTORY, ListingTypeInformation::AUCTION))
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