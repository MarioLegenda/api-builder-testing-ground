<?php

namespace FindingAPI\Core;

use FindingAPI\Core\Exception\ItemFilterException;
use Symfony\Component\Yaml\Yaml;

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
}