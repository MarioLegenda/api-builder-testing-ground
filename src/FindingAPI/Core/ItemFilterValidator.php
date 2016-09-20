<?php

namespace FindingAPI\Core;

use FindingAPI\Core\Exception\ItemFilterException;
use Symfony\Component\Yaml\Yaml;
use StrongType\ArrayType;

class ItemFilterValidator
{
    /**
     * @var array $itemFilters
     */
    private $itemFilters;
    /**
     * @var array $countryCodes
     */
    private $countryCodes = array();

    /**
     * @var \class_with_method_that_declares_anonymous_class
     */
    private $authorize;

    /**
     * ItemFilterProcessor constructor.
     * @param array $itemFilters
     */
    public function __construct(array $itemFilters)
    {
        $this->itemFilters = $itemFilters;

        $this->authorize = new class()
        {
            /**
             * @var array $countryCodes
             */
            private $countryCodes = array();
            /**
             * @param array $values
             * @param string $exceptionMessage
             * @throws ItemFilterException
             */
            public function authorizeBoolean(array $values, string $exceptionMessage)
            {
                if (count($values) !== 1) {
                    throw new ItemFilterException($exceptionMessage);
                }

                if (!is_bool($values[0])) {
                    throw new ItemFilterException($exceptionMessage);
                }
            }
            /**
             * @param array $values
             * @param string $exceptionMessage
             * @throws ItemFilterException
             */
            public function authorizeCountryCode(array $values, string $exceptionMessage)
            {
                if (count($values) !== 1) {
                    throw new ItemFilterException($exceptionMessage);
                }

                $userCode = $values[0];

                if (empty($this->countryCodes)) {
                    $countryCodes = Yaml::parse(file_get_contents(__DIR__.'/filter_config/country_codes.yml'));

                    foreach ($countryCodes['iso-codes'] as $codes) {
                        $this->countryCodes[] = $codes['alpha2'];
                    }
                }

                if (in_array($userCode, $this->countryCodes) === false) {
                    throw new ItemFilterException($exceptionMessage);
                }
            }

            public function condition(array $values, string $exceptionMessage)
            {
                $allowedValues = new ArrayType(array(
                    'text-values' => array('New', 'Used', 'Unspecified'),
                    'id-values' => array(1000, 1500, 1750, 2000, 2500, 3000, 4000, 5000, 6000, 7000),
                ));

                $uniques = array_unique($values);

                foreach ($uniques as $val) {
                    if (!$allowedValues->inArray($val, 'text-values') and !$allowedValues->inArray($val, 'id-values')) {
                        throw new ItemFilterException($exceptionMessage);
                    }
                }
            }
            /**
             * @param array $values
             * @param string $exceptionMessage
             * @throws ItemFilterException
             */
            public function currency(array $values, string $exceptionMessage)
            {
                $allowedCurrencies = new ArrayType(array(
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
                    'sgd',
                    'twd',
                    'usd',
                ));

                if (count($values) !== 1) {
                    throw new ItemFilterException($exceptionMessage);
                }

                $currency = strtolower($values[0]);

                if (!$allowedCurrencies->inArray($currency)) {
                    throw new ItemFilterException($exceptionMessage);
                }
            }
        };
    }

    /**
     * @void
     */
    public function validate()
    {
        foreach ($this->itemFilters as $name => $value) {
            $method = lcfirst($name);

            $this->{$method}($value);
        }
    }

    private function authorizedSellerOnly(array $values) : bool
    {
        $exceptionMessage = 'AuthorizedSeller only can accept only true or false boolean values and can be an array with one value';

        $this->authorize->authorizeBoolean($values, $exceptionMessage);

        return true;
    }

    private function availableTo(array $values) : bool
    {
        $exceptionMessage = 'Argument has to be an array with one value. Also, AvailableTo has to be a valid ISO 3166 country name. Please, refer to https://www.iso.org/obp/ui/#search';

        $this->authorize->authorizeCountryCode($values, $exceptionMessage);

        return true;
    }

    private function bestOfferOnly(array $values) : bool
    {
        $exceptionMessage = 'BestOfferOnly only can accept only true or false boolean values and can be an array with one value';

        $this->authorize->authorizeBoolean($values, $exceptionMessage);

        return true;
    }

    private function charityOnly(array $values) : bool
    {
        $exceptionMessage = 'BestOfferOnly only can accept only true or false boolean values and can be an array with one value';

        $this->authorize->authorizeBoolean($values, $exceptionMessage);

        return true;
    }

    private function condition(array $values) : bool
    {
        $exceptionMessage = 'Invalid item filter values for condition. Please, refer to http://developer.ebay.com/devzone/finding/callref/types/ItemFilterType.html';

        $this->authorize->condition($values, $exceptionMessage);

        return true;
    }

    private function currency(array $values) : bool
    {
        $exceptionMessage = 'Only one currency can be selected. Also, only valid currencies can be searched. Please, refer to http://developer.ebay.com/devzone/finding/callref/Enums/currencyIdList.html';

        $this->authorize->currency($values, $exceptionMessage);

        return true;
    }
}