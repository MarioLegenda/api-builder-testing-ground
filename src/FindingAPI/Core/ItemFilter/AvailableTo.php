<?php

namespace FindingAPI\Core\ItemFilter;

use FindingAPI\Core\Information\ISO3166CountryCodeInformation;

class AvailableTo extends BaseFindingDynamic
{
    /**
     * @return bool
     */
    public function validateDynamic() : bool
    {
        if (count($this->dynamicValue) !== 1) {
            $this->exceptionMessages[] = $this->name.' has to be an array argument with only one value';

            return false;
        }

        $userCode = $this->dynamicValue[0];

        if (ISO3166CountryCodeInformation::instance()->has($userCode) === false) {
            $this->exceptionMessages[] = $this->name.' has to receive an array with one value. Also, AvailableTo has to be a valid ISO 3166 country name. Please, refer to https://www.iso.org/obp/ui/#search\'';

            return false;
        }

        return true;
    }
}