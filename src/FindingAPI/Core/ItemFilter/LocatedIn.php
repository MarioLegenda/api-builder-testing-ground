<?php

namespace FindingAPI\Core\ItemFilter;

use FindingAPI\Core\Information\ISO3166CountryCode;

class LocatedIn extends AbstractFilter implements FilterInterface
{
    /**
     * @param array $filter
     * @return bool
     */
    public function validateFilter() : bool
    {
        if (count($this->filter) > 25) {
            $this->exceptionMessages[] = $this->name.' can specify up to 25 countries. '.count($this->filter).' given';

            return false;
        }

        foreach ($this->filter as $code) {
            if (!ISO3166CountryCode::instance()->has($code)) {
                $this->exceptionMessages[] = 'Unknown ISO31566 country code '.$code.'. Please, refere to https://www.iso.org/obp/ui/#search';

                return false;
            }
        }

        return true;
    }
}