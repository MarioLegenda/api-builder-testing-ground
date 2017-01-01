<?php

namespace FindingAPI\Core\ItemFilter;

use FindingAPI\Core\Information\ISO3166CountryCode;

class AvailableTo extends AbstractFilter implements FilterInterface
{
    /**
     * @return bool
     */
    public function validateFilter() : bool
    {
        if (count($this->filter) !== 1) {
            $this->exceptionMessages[] = $this->name.' has to be an array argument with only one value';

            return false;
        }

        $userCode = $this->filter[0];

        if (ISO3166CountryCode::instance()->has($userCode) === false) {
            $this->exceptionMessages[] = $this->name.' has to receive an array with one value. Also, AvailableTo has to be a valid ISO 3166 country name. Please, refer to https://www.iso.org/obp/ui/#search\'';

            return false;
        }

        return true;
    }
}