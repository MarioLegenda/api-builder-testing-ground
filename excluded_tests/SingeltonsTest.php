<?php

namespace Test;

require __DIR__ . '/../vendor/autoload.php';

use FindingAPI\Core\Information\GlobalIdInformation;
use FindingAPI\Core\Information\ListingTypeInformation;
use FindingAPI\Core\Information\OutputSelectorInformation;
use FindingAPI\Core\Information\ISO3166CountryCodeInformation;
use FindingAPI\Core\Information\SortOrderInformation;
use FindingAPI\Core\Information\CurrencyInformation;
use FindingAPI\Core\Information\PaymentMethodInformation;
use Symfony\Component\Yaml\Yaml;

class SingeltonsTest extends \PHPUnit_Framework_TestCase
{
    public function testGlobalId()
    {
        $globalIds = array(
            'ebay-at' => array(
                'global-id' => 'EBAY-AT',
                'language' => 'de-AT',
                'teritory' => 'AT',
                'site-name' => 'Ebay Austria',
                'ebay-site-id' => 16,
            ),
            'ebAy-au' => array(
                'global-id' => 'EBAY-AU',
                'language' => 'en-AU',
                'teritory' => 'AU',
                'site-name' => 'Ebay Australia',
                'ebay-site-id' => 15,
            ),
            'ebay-ch' => array(
                'global-id' => 'EBAY-CH',
                'language' => 'de-CH',
                'teritory' => 'CH',
                'site-name' => 'eBay Switzerland',
                'ebay-site-id' => 193,
            ),
            'ebay-dE' => array(
                'global-id' => 'EBAY-DE',
                'language' => 'de-DE',
                'teritory' => 'DE',
                'site-name' => 'eBay Germany',
                'ebay-site-id' => 77,
            ),
            'ebay-enca' => array(
                'global-id' => 'EBAY-ENCA',
                'language' => 'en-CA',
                'teritory' => 'CA',
                'site-name' => 'eBay Canada (English)',
                'ebay-site-id' => 2,
            ),
            'ebay-es' => array(
                'global-id' => 'EBAY-ES',
                'language' => 'es-ES',
                'teritory' => 'ES',
                'site-name' => 'eBay Spain',
                'ebay-site-id' => 186,
            ),
            'ebay-fr' => array(
                'global-id' => 'EBAY-FR',
                'language' => 'fr-FR',
                'teritory' => 'FR',
                'site-name' => 'eBay France',
                'ebay-site-id' => 71,
            ),
            'ebay-frbe' => array(
                'global-id' => 'EBAY-FRBE',
                'language' => 'fr-BE',
                'teritory' => 'BE',
                'site-name' => 'eBay Belgium (French)',
                'ebay-site-id' => 23,
            ),
            'ebay-frca' => array(
                'global-id' => 'EBAY-FRCA',
                'language' => 'fr-CA',
                'teritory' => 'CA',
                'site-name' => 'eBay Canada (French)',
                'ebay-site-id' => 210,
            ),
            'ebay-gb' => array(
                'global-id' => 'EBAY-GB',
                'language' => 'en-GB',
                'teritory' => 'GB',
                'site-name' => 'eBay UK',
                'ebay-site-id' => 3,
            ),
            'ebay-hk' => array(
                'global-id' => 'EBAY-HK',
                'language' => 'zh-Hant',
                'teritory' => 'HK',
                'site-name' => 'eBay Hong Kong',
                'ebay-site-id' => 201,
            ),
            'ebay-ie' => array(
                'global-id' => 'EBAY-IE',
                'language' => 'en-IE',
                'teritory' => 'IE',
                'site-name' => 'eBay Ireland',
                'ebay-site-id' => 205,
            ),
            'ebay-iN' => array(
                'global-id' => 'EBAY-IN',
                'language' => 'en-IN',
                'teritory' => 'IN',
                'site-name' => 'eBay India',
                'ebay-site-id' => 203,
            ),
            'ebay-it' => array(
                'global-id' => 'EBAY-IT',
                'language' => 'it-IT',
                'teritory' => 'IT',
                'site-name' => 'eBay Italy',
                'ebay-site-id' => 101,
            ),
            'ebay-motor' => array(
                'global-id' => 'EBAY-MOTOR',
                'language' => 'en-US',
                'teritory' => 'US',
                'site-name' => 'eBay Motors',
                'ebay-site-id' => 100,
            ),
            'ebay-my' => array(
                'global-id' => 'EBAY-MY',
                'language' => 'en-MY',
                'teritory' => 'MY',
                'site-name' => 'eBay Malaysia',
                'ebay-site-id' => 207,
            ),
            'ebay-nl' => array(
                'global-id' => 'EBAY-NL',
                'language' => 'nl-NL',
                'teritory' => 'NL',
                'site-name' => 'eBay Netherlands',
                'ebay-site-id' => 146,
            ),
            'ebay-nlbe' => array(
                'global-id' => 'EBAY-NLBE',
                'language' => 'nl-BE',
                'teritory' => 'BE',
                'site-name' => 'eBay Belgium (Dutch)',
                'ebay-site-id' => 123,
            ),
            'ebay-ph' => array(
                'global-id' => 'EBAY-PH',
                'language' => 'en-PH',
                'teritory' => 'PH',
                'site-name' => 'eBay Philippines',
                'ebay-site-id' => 212,
            ),
            'ebay-pl' => array(
                'global-id' => 'EBAY-PL',
                'language' => 'pl-PL',
                'teritory' => 'PL',
                'site-name' => 'eBay Poland',
                'ebay-site-id' => 212,
            ),
            'ebay-sg' => array(
                'global-id' => 'EBAY-SG',
                'language' => 'en-SG',
                'teritory' => 'SG',
                'site-name' => 'eBay Singapore',
                'ebay-site-id' => 216,
            ),
            'ebay-us' => array(
                'global-id' => 'EBAY-US',
                'language' => 'en-US',
                'teritory' => 'US',
                'site-name' => 'eBay United States',
                'ebay-site-id' => 0,
            ),
        );

        foreach ($globalIds as $key => $values) {
            $this->assertTrue(GlobalIdInformation::instance()->has($key));

            $id = GlobalIdInformation::instance()->get($key);
            $this->assertEquals($id, strtoupper($key), $id.' and '.$key.' are not equal');

            GlobalIdInformation::instance()->remove($key);

            $this->assertFalse(GlobalIdInformation::instance()->has($key), 'GlobalId::hasId() for key '.$key.' should return false');

            GlobalIdInformation::instance()->add($key, $values);

            $id = GlobalIdInformation::instance()->get($key);
            $this->assertEquals($id, strtoupper($key), $id.' and '.$key.' are not equal after removal');
        }
    }

    public function testCountryCode()
    {
        $countryCodes = Yaml::parse(file_get_contents(__DIR__ . '/../src/ebay-finding-api/src/FindingAPI/Core/Information/country_codes.yml'))['iso-codes'];

        foreach ($countryCodes as $codes) {
            foreach ($codes as $key => $codeInLoop) {
                $this->assertTrue(ISO3166CountryCodeInformation::instance()->has($codeInLoop), 'Failed asserting that '.$codeInLoop.' is valid');
            }

            $countryName = $codes['name'];
            $alpha2 = $codes['alpha2'];
            $alpha3 = $codes['alpha3'];
            $number = $codes['number'];

            $code = ISO3166CountryCodeInformation::instance()->get($countryName);
            $this->assertEquals($code['name'], $countryName, $countryName.' and '.$code['name'].' are not equal');

            $code = ISO3166CountryCodeInformation::instance()->get($alpha2);
            $this->assertEquals($code['alpha2'], $alpha2, $alpha2.' and '.$code['alpha2'].' are not equal');

            $code = ISO3166CountryCodeInformation::instance()->get($alpha3);
            $this->assertEquals($code['alpha3'], $alpha3, $alpha3.' and '.$code['alpha3'].' are not equal');

            $code = ISO3166CountryCodeInformation::instance()->get($countryName);
            $this->assertEquals($code['number'], $number, $number.' and '.$code['number'].' are not equal');
        }

        ISO3166CountryCodeInformation::instance()->add(array(
            'name' => 'Mile',
            'alpha2' => 'HGOS',
        ));

        $this->assertTrue(ISO3166CountryCodeInformation::instance()->has('HGOS'), 'Failed asserting that HGOS exists as a country code');

        $this->assertTrue(ISO3166CountryCodeInformation::instance()->remove('HGOS'), 'Failed asserting that HGOS has been deleted');

        $this->assertFalse(ISO3166CountryCodeInformation::instance()->has('HGOS'), 'Failed asserting that HGOS does not exist as a country code');

        $this->assertTrue(ISO3166CountryCodeInformation::instance()->has('HGOS', true), 'Failed asserting that HGOS exists but has be removed as a country code');

        ISO3166CountryCodeInformation::instance()->add(array(
            'name' => 'Mile',
            'alpha2' => 'HGOS',
        ));

        $this->assertTrue(ISO3166CountryCodeInformation::instance()->has('HGOS'), 'Failed asserting that HGOS exists as a country code after deleting and adding again');
    }

    public function testOtherInformationSingeltons()
    {
        $sortOrders = array(
            'BestMatch',
            'BidCountFewest',
            'BidCountMost',
            'CountryAscending',
            'CountryDescending',
            'CurrentPriceHighest',
            'DistanceNearest',
            'EndTimeSoonest',
            'PricePlusShippingHighest',
            'PricePlusShippingLowest',
            'StartTimeNewest',
        );

        foreach ($sortOrders as $sort) {
            $this->assertTrue(SortOrderInformation::instance()->has($sort), $sort.' does not exist in '.get_class(SortOrderInformation::instance()));
        }

        $this->assertNotNull(SortOrderInformation::instance()->add('SomeNewSortOrder'), 'Could not add new sort order SomeNewSortOrder');

        $this->assertTrue(SortOrderInformation::instance()->has('SomeNewSortOrder'), 'SomeNewSortOrder does not exist in '.get_class(SortOrderInformation::instance()));

        $currencies = array(
            'AUD',
            'CAD',
            'CHR',
            'CNY',
            'EUR',
            'GBP',
            'HKD',
            'INR',
            'MYR',
            'PHP',
            'PLN',
            'SEK',
            'TWD',
            'USD',
        );

        foreach ($currencies as $currency) {
            $this->assertTrue(CurrencyInformation::instance()->has($currency), $currency.' does not exist in '.get_class(CurrencyInformation::instance()));
        }

        $this->assertNotNull(CurrencyInformation::instance()->add('SomeNewCurrency'), 'Could not add new currency SomeNewCurrency');

        $this->assertTrue(CurrencyInformation::instance()->has('SomeNewCurrency'), 'SomeNewCurrency does not exist in '.get_class(CurrencyInformation::instance()));

        $this->assertTrue(CurrencyInformation::instance()->remove('SomeNewCurrency'), 'SomeNewCurrency could not be removed');

        $this->assertFalse(CurrencyInformation::instance()->has('someNewCurrency'), 'SomeNewCurrency should not exist after removal');

        $paymentMethods = array(
            'PayPal',
            'PaisaPal',
            'PaisaPayEMI',
        );


        foreach ($paymentMethods as $method) {
            $this->assertTrue(PaymentMethodInformation::instance()->has($method), $method.' does not exist in '.get_class(PaymentMethodInformation::instance()));
        }

        $this->assertNotNull(PaymentMethodInformation::instance()->add('Visa'), 'Could not add new payment method Visa');

        $this->assertTrue(PaymentMethodInformation::instance()->has('Visa'), 'Visa does not exist in '.get_class(PaymentMethodInformation::instance()));

        $this->assertTrue(PaymentMethodInformation::instance()->remove('Visa'), 'Visa could not be removed as payment method');

        $this->assertFalse(PaymentMethodInformation::instance()->has('Visa'), 'Visa should not be a payment method after removal');

        $listingTypes = array(
            'All',
            'Auction',
            'AuctionWithBIN',
            'Classified',
            'FixedPrice',
            'StoreInventory'
        );

        foreach ($listingTypes as $method) {
            $this->assertTrue(ListingTypeInformation::instance()->has($method), $method.' does not exist in '.ListingTypeInformation::class);
        }

        $this->assertNotNull(ListingTypeInformation::instance()->add('Sold'), 'Could not add new listing type Sold');

        $this->assertTrue(ListingTypeInformation::instance()->has('Sold'), 'Sold does not exist in '.ListingTypeInformation::class);

        $this->assertTrue(ListingTypeInformation::instance()->remove('Sold'), 'Sold could not be removed as listing type');

        $this->assertFalse(ListingTypeInformation::instance()->has('Sold'), 'Sold should not be a listing type after removal');

        $outputSelectors = array(
            'AspectHistogram',
            'CategoryHistogram',
            'ConditionHistogram',
            'GalleryInfo',
            'PictureURLLarge',
            'PictureURLSuperSize',
            'SellerInfo',
            'StoreInfo',
            'UnitPriceInfo',
        );

        foreach ($outputSelectors as $method) {
            $this->assertTrue(OutputSelectorInformation::instance()->has($method), $method.' does not exist in '.OutputSelectorInformation::class);
        }

        $this->assertNotNull(OutputSelectorInformation::instance()->add('IsSold'), 'Could not add new output selector IsSold');

        $this->assertTrue(OutputSelectorInformation::instance()->has('IsSold'), 'IsSold does not exist in '.OutputSelectorInformation::class);

        $this->assertTrue(OutputSelectorInformation::instance()->remove('IsSold'), 'IsSold could not be removed as output selector');

        $this->assertFalse(OutputSelectorInformation::instance()->has('IsSold'), 'IsSold should not be a output selector after removal');

        $sortOrders = array(
            'BestMatch',
            'BidCountFewest',
            'BidCountMost',
            'CountryAscending',
            'CountryDescending',
            'CurrentPriceHighest',
            'DistanceNearest',
            'EndTimeSoonest',
            'PricePlusShippingHighest',
            'PricePlusShippingLowest',
            'StartTimeNewest',
        );

        foreach ($sortOrders as $method) {
            $this->assertTrue(SortOrderInformation::instance()->has($method), $method.' does not exist in '.SortOrderInformation::class);
        }

        $this->assertNotNull(SortOrderInformation::instance()->add('ByDate'), 'Could not add new sort order ByDate');

        $this->assertTrue(SortOrderInformation::instance()->has('ByDate'), 'ByDate does not exist in '.SortOrderInformation::class);

        $this->assertTrue(SortOrderInformation::instance()->remove('ByDate'), 'ByDate could not be removed as sort order');

        $this->assertFalse(SortOrderInformation::instance()->has('ByDate'), 'ByDate should not be a sort order after removal');
    }
}