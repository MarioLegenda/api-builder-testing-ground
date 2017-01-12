<?php

namespace Test;

use SDKBuilder\SDKBuilder;
use ShoppingAPI\Dynamic\DomainNameDynamic;
use ShoppingAPI\Information\ProductSortInformation;
use ShoppingAPI\Information\SortOrderInformation;
use ShoppingAPI\ShoppingAPI;
use ShoppingAPI\ShoppingEnum;

require __DIR__ . '/../vendor/autoload.php';

class ShoppingAPITest extends \PHPUnit_Framework_TestCase
{
    public function testCreation()
    {
        SDKBuilder::inst()->registerApi('shopping', __DIR__.'/shopping.yml');

        $shoppingApi = SDKBuilder::inst()->create('shopping');

        $this->assertInstanceOf(ShoppingAPI::class, $shoppingApi, 'ShoppingApi should be an instance of '.ShoppingAPI::class);
    }

    public function testBareApi()
    {
        $shoppingApi = SDKBuilder::inst()->create('shopping');

        $dynamicStorage = $shoppingApi->getRequest()->getDynamicStorage();

        $this->assertTrue($dynamicStorage->hasDynamic(ShoppingEnum::DOMAIN_NAME), 'DomainName dynamic does not exist');

        $shoppingApi
            ->getRequest()
            ->setSpecialParameter('callname', 'FindHalfProducts')
            ->setSpecialParameter('response_encoding', 'xml')
            ->setSpecialParameter('available_items_only', true)
            ->setSpecialParameter('page_number', 2)
            ->setSpecialParameter('keywords', 'harry potter')
            ->setSpecialParameter(ShoppingEnum::SORT_ORDER, SortOrderInformation::ASCENDING)
            ->addDynamic(ShoppingEnum::PRODUCT_SORT, array(ProductSortInformation::POPULARITY));

        $response = $shoppingApi
            ->compile()
            ->send()
            ->getResponse();

        var_dump($shoppingApi->getProcessedRequestString());

        var_dump($response);

        $this->assertInternalType('string', $response, 'Response should be a string');
    }
}