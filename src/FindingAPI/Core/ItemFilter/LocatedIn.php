<?php

namespace FindingAPI\Core\ItemFilter;

use FindingAPI\Core\Information\ISO3166CountryCode;

class LocatedIn extends AbstractConstraint implements FilterInterface
{
    /**
     * @param array $filter
     * @return bool
     */
    public function validateFilter(array $filter) : bool
    {
        if (count($filter) > 25) {
            $this->exceptionMessages[] = $this->name.' can specify up to 25 countries. '.count($filter).' given';

            return false;
        }

        foreach ($filter as $code) {
            if (!ISO3166CountryCode::instance()->has($code)) {
                $this->exceptionMessages[] = 'Unknown ISO31566 country code '.$code.'. Please, refere to https://www.iso.org/obp/ui/#search';

                return false;
            }
        }

        return true;
    }
}