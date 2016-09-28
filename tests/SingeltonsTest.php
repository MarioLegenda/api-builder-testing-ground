<?php

require __DIR__ . '/../vendor/autoload.php';

use FindingAPI\Core\Information\GlobalId;
use Symfony\Component\Yaml\Yaml;
use FindingAPI\Core\Information\ISO3166CountryCode;
use FindingAPI\Core\Information\SortOrder;
use FindingAPI\Core\Information\Currency;
use FindingAPI\Core\Information\PaymentMethod;

class SingeltonsTest extends PHPUnit_Framework_TestCase
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
            'ebay-au' => array(
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
            'ebay-de' => array(
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
            'ebay-in' => array(
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
            $this->assertTrue(GlobalId::instance()->has($key));

            $id = GlobalId::instance()->get($key);
            $this->assertEquals($id, strtoupper($key), $id.' and '.$key.' are not equal');

            GlobalId::instance()->remove($key);

            $this->assertFalse(GlobalId::instance()->has($key), 'GlobalId::hasId() for key '.$key.' should return false');

            GlobalId::instance()->add($key, $values);

            $id = GlobalId::instance()->get($key);
            $this->assertEquals($id, strtoupper($key), $id.' and '.$key.' are not equal after removal');
        }
    }

    public function testCountryCode()
    {
        $countryCodes = Yaml::parse(file_get_contents(__DIR__.'/../src/FindingAPI/Core/Information/country_codes.yml'))['iso-codes'];

        foreach ($countryCodes as $codes) {
            foreach ($codes as $key => $codeInLoop) {
                $this->assertTrue(ISO3166CountryCode::instance()->has($codeInLoop), 'Failed asserting that '.$codeInLoop.' is valid');
            }

            $countryName = $codes['name'];
            $alpha2 = $codes['alpha2'];
            $alpha3 = $codes['alpha3'];
            $number = $codes['number'];

            $code = ISO3166CountryCode::instance()->get($countryName);
            $this->assertEquals($code['name'], $countryName, $countryName.' and '.$code['name'].' are not equal');

            $code = ISO3166CountryCode::instance()->get($alpha2);
            $this->assertEquals($code['alpha2'], $alpha2, $alpha2.' and '.$code['alpha2'].' are not equal');

            $code = ISO3166CountryCode::instance()->get($alpha3);
            $this->assertEquals($code['alpha3'], $alpha3, $alpha3.' and '.$code['alpha3'].' are not equal');

            $code = ISO3166CountryCode::instance()->get($countryName);
            $this->assertEquals($code['number'], $number, $number.' and '.$code['number'].' are not equal');
        }

        ISO3166CountryCode::instance()->add(array(
            'name' => 'Mile',
            'alpha2' => 'HGOS',
        ));

        $this->assertTrue(ISO3166CountryCode::instance()->has('HGOS'), 'Failed asserting that HGOS exists as a country code');

        $this->assertTrue(ISO3166CountryCode::instance()->remove('HGOS'), 'Failed asserting that HGOS has been deleted');

        $this->assertFalse(ISO3166CountryCode::instance()->has('HGOS'), 'Failed asserting that HGOS does not exist as a country code');

        $this->assertTrue(ISO3166CountryCode::instance()->has('HGOS', true), 'Failed asserting that HGOS exists but has be removed as a country code');

        ISO3166CountryCode::instance()->add(array(
            'name' => 'Mile',
            'alpha2' => 'HGOS',
        ));

        $this->assertTrue(ISO3166CountryCode::instance()->has('HGOS'), 'Failed asserting that HGOS exists as a country code after deleting and adding again');
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
            $this->assertTrue(SortOrder::instance()->has($sort), $sort.' does not exist in '.get_class(SortOrder::instance()));
        }

        $this->assertNotNull(SortOrder::instance()->add('SomeNewSortOrder'), 'Could not add new sort order SomeNewSortOrder');

        $this->assertTrue(SortOrder::instance()->has('SomeNewSortOrder'), 'SomeNewSortOrder does not exist in '.get_class(SortOrder::instance()));

        $currencies = array(
            'aud',
            'cad',
            'chf',
            'cny',
            'eur',
            'gbp',
            'hkd',
            'inr',
            'myr',
            'php',
            'pln',
            'sek',
            'twd',
            'usd',
        );

        foreach ($currencies as $currency) {
            $this->assertTrue(Currency::instance()->has($currency), $currency.' does not exist in '.get_class(Currency::instance()));
        }

        $this->assertNotNull(Currency::instance()->add('SomeNewCurrency'), 'Could not add new currency SomeNewCurrency');

        $this->assertTrue(Currency::instance()->has('SomeNewCurrency'), 'SomeNewCurrency does not exist in '.get_class(Currency::instance()));

        $paymentMethods = array(
            'PayPal',
            'PaisaPal',
            'PaisaPayEMI',
        );


        foreach ($paymentMethods as $method) {
            $this->assertTrue(PaymentMethod::instance()->has($method), $method.' does not exist in '.get_class(PaymentMethod::instance()));
        }

        $this->assertNotNull(PaymentMethod::instance()->add('Visa'), 'Could not add new payment method Visa');

        $this->assertTrue(PaymentMethod::instance()->has('Visa'), 'Visa does not exist in '.get_class(PaymentMethod::instance()));
    }
}