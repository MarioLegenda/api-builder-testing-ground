<?php

namespace FindingAPI\Core\ItemFilter;

use FindingAPI\Core\Information\ListingTypeInformation;
use SDKBuilder\Dynamic\AbstractDynamic;
use SDKBuilder\Dynamic\DynamicInterface;

class ListingType extends AbstractDynamic implements DynamicInterface
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