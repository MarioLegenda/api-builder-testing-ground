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

        $foundFilters = $itemFilterStorage->getItemFiltersInBulk(array('AvailableTo', 'LocatedIn'), true);

        if (count($foundFilters) > 1) {
            throw new ItemFilterException('AvailableTo item filter cannot be used together with LocatedIn item filter and vice versa');
        }

        if ($itemFilterStorage->hasItemFilter('LocalSearchOnly')) {
            $localSearchOnly = $itemFilterStorage->getItemFilter('LocalSearchOnly');

            if ($localSearchOnly['value'] !== null) {
                $maxDistance = $itemFilterStorage->getItemFilter('MaxDistance');
                $buyerPostalCode = $itemFilterStorage->getItemFilter('BuyerPostalCode');

                if ($maxDistance['value'] === null or $buyerPostalCode['value'] === null) {
                    throw new ItemFilterException('LocalSearchOnly item filter has to be used together with MaxDistance item filter and buyerPostalCode');
                }
            }
        }

        if ($itemFilterStorage->hasItemFilter('MaxDistance')) {
            $maxDistance = $itemFilterStorage->getItemFilter('MaxDistance');

            if ($maxDistance['value'] !== null) {
                $buyerPostalCode = $itemFilterStorage->getItemFilter('BuyerPostalCode');

                if ($buyerPostalCode['value'] === null) {
                    throw new ItemFilterException('MaxDistance item filter has to be used together with buyerPostalCode');
                }
            }
        }
    }
}