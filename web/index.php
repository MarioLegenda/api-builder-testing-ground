<?php

require_once __DIR__.'/../vendor/autoload.php';

use FindingAPI\Finding;
use FindingAPI\Core\Request\Request;

use FindingAPI\Core\Information\OperationName;
use FindingAPI\Definition\Definition;
use FindingAPI\Core\ItemFilter\ItemFilter;
use FindingAPI\Core\Information\Currency as InformationCurrency;
use FindingAPI\Core\Options\Options;


$request = new Request();

$request
    ->setOperationName(OperationName::FIND_ITEMS_BY_KEYWORDS)
    ->setMethod('get')
    ->setResponseDataFormat('xml')
    ->setSecurityAppId('Mariokrl-testing-PRD-ee6e68035-e73c8a53')
    ->setOutputSelector(array('SellerInfo', 'StoreInfo', 'CategoryHistogram', 'AspectHistogram'))
    ->addItemFilter(ItemFilter::BEST_OFFER_ONLY, array(true))
    ->addItemFilter(ItemFilter::CURRENCY, array(InformationCurrency::AUSTRALIAN))
    ->addSearch(Definition::customDefinition('harry potter'));

$finder = Finding::getInstance($request);

$finder->setOption(Options::OFFLINE_MODE, true);

$response = $finder->send()->getResponse();

$body = $response->getGuzzleResponse()->getBody();

$dom = new DOMDocument();
$dom->loadXML($body);

$dom->preserveWhiteSpace = false;
$dom->formatOutput = true;

$xmlString = $dom->saveXML();

echo "<pre>";
echo htmlspecialchars($xmlString);
