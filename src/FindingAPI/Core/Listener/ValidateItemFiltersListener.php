<?php

namespace FindingAPI\Core\Listener;

use FindingAPI\Core\Exception\ItemFilterException;
use SDKBuilder\Event\PreProcessRequestEvent;

class ValidateItemFiltersListener
{
    /**
     * @param PreProcessRequestEvent $event
     */
    public function onPreProcessRequest(PreProcessRequestEvent $event)
    {
        $itemFilterStorage = $event->getRequest()->getItemFilterStorage();

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

        if ($itemFilterStorage->hasItemFilter('FeedbackScoreMin') and $itemFilterStorage->hasItemFilter('FeedbackScoreMax')) {
            $feedbackScoreMax = $itemFilterStorage->getItemFilter('FeedbackScoreMax');
            $feedbackScoreMin = $itemFilterStorage->getItemFilter('FeedbackScoreMin');

            if ($feedbackScoreMax['value'] < $feedbackScoreMin['value']) {
                throw new ItemFilterException('If provided, FeedbackScoreMax has to larger or equal than FeedbackScoreMin');
            }
        }

        if ($itemFilterStorage->hasItemFilter('MaxBids') and $itemFilterStorage->hasItemFilter('MinBids')) {
            $maxBids = $itemFilterStorage->getItemFilter('MaxBids');
            $minBids = $itemFilterStorage->getItemFilter('MinBids');

            if ($maxBids['value'] < $minBids['value']) {
                throw new ItemFilterException('If provided, MaxBids has to larger or equal than MinBids');
            }
        }

        if ($itemFilterStorage->hasItemFilter('MaxQuantity') and $itemFilterStorage->hasItemFilter('MinQuantity')) {
            $maxQuantity = $itemFilterStorage->getItemFilter('MaxQuantity');
            $minQuantity = $itemFilterStorage->getItemFilter('MinQuantity');

            if ($maxQuantity['value'] < $minQuantity['value']) {
                throw new ItemFilterException('If provided, MaxQuantity has to larger or equal than MinQuantity');
            }
        }
    }
}