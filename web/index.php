<?php

require_once __DIR__.'/../vendor/autoload.php';

use SDKBuilder\SDKBuilder;
use FindingAPI\FindingFactory;
use FindingAPI\Core\ItemFilter\ItemFilter;
use FindingAPI\Core\Information\Currency;


$findingApi = SDKBuilder::inst()
    ->registerApi('finding', __DIR__.'/../tests/finding.yml')
    ->create('finding');

$findingApi->switchOfflineMode(false);

$findingApi
    ->findItemsByKeywords()
    ->addKeywords('call of duty')
    ->setOutputSelector(array('SellerInfo', 'StoreInfo', 'CategoryHistogram', 'AspectHistogram'))
    ->addItemFilter(ItemFilter::BEST_OFFER_ONLY, array(true))
    ->addItemFilter(ItemFilter::CURRENCY, array(Currency::AUSTRALIAN));

$response = $findingApi
    ->compile()
    ->send()
    ->getResponse();

$dom = new DOMDocument();
$dom->loadXML($response->getRawResponse());

$dom->preserveWhiteSpace = false;
$dom->formatOutput = true;

$xmlString = $dom->saveXML();

echo "<pre>";
echo htmlspecialchars($xmlString);
