<?php

namespace FindingAPI\Core\ItemFilter;

use FindingAPI\Core\Information\ISO3166CountryCodeInformation;

class LocatedIn extends BaseFindingDynamic
{
    /**
     * @return bool
     */
    public function validateDynamic() : bool
    {
        if (count($this->dynamicValue) > 25) {
            $this->exceptionMessages[] = $this->name.' can specify up to 25 countries. '.count($this->dynamicValue).' given';

            return false;
        }

        foreach ($this->dynamicValue as $code) {
            if (!ISO3166CountryCodeInformation::instance()->has($code)) {
                $this->exceptionMessages[] = 'Unknown ISO31566 country code '.$code.'. Please, refere to https://www.iso.org/obp/ui/#search';

                return false;
            }
        }

        return true;
    }
}