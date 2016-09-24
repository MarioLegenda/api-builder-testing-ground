<?php

namespace FindingAPI\Core\ItemFilter;

use Symfony\Component\Yaml\Yaml;
use FindingAPI\Core\ISO3166CountryCode;

class AvailableTo extends AbstractConstraint implements FilterInterface
{
    /**
     * @param array $filter
     * @return bool
     */
    public function validateFilter(array $filter) : bool
    {
        if (count($filter) !== 1) {
            $this->exceptionMessages[] = $this->name.' has to be an array argument with only one value';

            return false;
        }

        $userCode = $filter[0];

        if (ISO3166CountryCode::instance()->hasId($userCode) === false) {
            $this->exceptionMessages[] = $this->name.' has to receive an array with one value. Also, AvailableTo has to be a valid ISO 3166 country name. Please, refer to https://www.iso.org/obp/ui/#search\'';

            return false;
        }

        return true;
    }
}