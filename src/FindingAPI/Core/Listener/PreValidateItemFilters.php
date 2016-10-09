<?php

namespace FindingAPI\Core\Listener;

use FindingAPI\Core\Event\ItemFilterEvent;
use FindingAPI\Core\Exception\ItemFilterException;

class PreValidateItemFilters
{
    /**
     * @param ItemFilterEvent $event
     * @throws ItemFilterException
     */
    public function onPreValidate(ItemFilterEvent $event)
    {
        $itemFilterStorage = $event->getItemFilterStorage();

        $foundFilters = $itemFilterStorage->getItemFiltersInBulk(array('ExcludeSeller', 'Seller', 'TopRatedSellerOnly'), true);

        if (count($foundFilters) > 1) {
            throw new ItemFilterException('The ExcludeSeller item filter cannot be used together with either the Seller or TopRatedSellerOnly item filters or vice versa');
        }
    }
}