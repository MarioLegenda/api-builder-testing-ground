<?php

require __DIR__ . '/../vendor/autoload.php';

use FindingAPI\Core\GlobalId;
use Symfony\Component\Yaml\Yaml;
use FindingAPI\Core\ISO3166CountryCode;

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
            $this->assertTrue(GlobalId::instance()->hasId($key));

            $id = GlobalId::instance()->getId($key)['global-id'];
            $this->assertEquals($id, strtoupper($key), $id.' and '.$key.' are not equal');
        }
    }

    public function testCountryCode()
    {
        $countryCodes = Yaml::parse(file_get_contents(__DIR__.'/../src/FindingAPI/Core/ItemFilter/country_codes.yml'))['iso-codes'];

        foreach ($countryCodes as $codes) {
            $this->assertTrue(ISO3166CountryCode::instance()->hasId($codes['alpha2']), 'Invalid code '.$codes['alpha2']);

            $code = ISO3166CountryCode::instance()->getId($codes['alpha2'], 'alpha2');
            $this->assertEquals($code, $codes['alpha2'], $code.' and '.$codes['alpha2'].' are not equal');
        }
    }
}