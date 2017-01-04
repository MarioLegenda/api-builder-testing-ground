<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__.'/../vendor/autoload.php';

use SDKBuilder\SDKBuilder;
use FindingAPI\FindingFactory;
use FindingAPI\Core\ItemFilter\ItemFilter;
use FindingAPI\Core\Information\Currency;
use Demo\TwigBridge;

$findingApi = SDKBuilder::inst()
                ->registerApi('finding', FindingFactory::class)
                ->create('finding');

$findingApi
    ->findItemsByKeywords()
    ->addKeywords('harry potter')
    ->setOutputSelector(array('SellerInfo', 'StoreInfo', 'CategoryHistogram', 'AspectHistogram'))
    ->addItemFilter(ItemFilter::BEST_OFFER_ONLY, array(true))
    ->addItemFilter(ItemFilter::CURRENCY, array(Currency::AUSTRALIAN));

$response = $findingApi
                ->compile()
                ->send()
                ->getResponse();

$twigBridge = new TwigBridge();

echo $twigBridge->getTwig()->render('index.html.twig', array(
    'response' => $response,
    'processed' => $findingApi->getProcessedRequestString(),
));