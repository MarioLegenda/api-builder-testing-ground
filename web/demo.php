<?php

require_once __DIR__.'/../vendor/autoload.php';

use FindingAPI\Finding;
use FindingAPI\Core\Request\Request;

use FindingAPI\Core\Information\OperationName;
use FindingAPI\Definition\Definition;
use FindingAPI\Core\ItemFilter\ItemFilter;
use FindingAPI\Core\Information\Currency as InformationCurrency;
use FindingAPI\Core\Options\Options;
use Demo\TwigBridge;

$request = new Request();

$request
    ->setOperationName(OperationName::FIND_ITEMS_BY_KEYWORDS)
    ->setMethod('get')
    ->setResponseDataFormat('xml')
    ->setSecurityAppId('Mariokrl-testing-PRD-ee6e68035-e73c8a53')
    ->setOutputSelector(array('SellerInfo', 'StoreInfo', 'CategoryHistogram', 'AspectHistogram'))
    ->addItemFilter(ItemFilter::BEST_OFFER_ONLY, array(true))
    ->addItemFilter(ItemFilter::CURRENCY, array(InformationCurrency::AUSTRALIAN))
    ->addSearch(Definition::customDefinition('call of duty'));

$finder = Finding::getInstance($request);

$finder->setOption(Options::OFFLINE_MODE, true);

$response = $finder->send()->getResponse();

$twigBridge = new TwigBridge();

echo $twigBridge->getTwig()->render('index.html.twig', array(
    'response' => $response,
    'processed' => $finder->getProcessed(),
));