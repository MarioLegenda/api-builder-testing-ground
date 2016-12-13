<?php

namespace FindingAPI\Core\ItemFilter;

class ListingType extends AbstractFilter implements FilterInterface
{
    /**
     * @return bool
     */
    public function validateFilter() : bool
    {
        $filter = $this->filter[0];
        $validFilters = array('All', 'AuctionWithBIN', 'Classified', 'FixedPrice', 'StoreInventory');

        if (in_array($filter, $validFilters) === false) {
            $this->exceptionMessages[] = $this->name.' accepts only '.implode(', ', $validFilters).' values';

            return false;
        }

        return true;
    }
}