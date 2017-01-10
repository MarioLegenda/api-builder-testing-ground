<?php

namespace FindingAPI\Core\ItemFilter;

use FindingAPI\Core\Information\ListingTypeInformation;

class ListingType extends BaseFindingDynamic
{
    /**
     * @return bool
     */
    public function validateDynamic() : bool
    {
        $filter = $this->dynamicValue[0];
        $validFilters = ListingTypeInformation::instance()->getAll();

        if (in_array($filter, $validFilters) === false) {
            $this->exceptionMessages[] = $this->name.' accepts only '.implode(', ', $validFilters).' values';

            return false;
        }

        return true;
    }
}