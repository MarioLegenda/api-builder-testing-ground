<?php

namespace FindingAPI\Core\Listener;

use FindingAPI\Core\Exception\ItemFilterException;

use FindingAPI\Core\Information\ { GlobalIdInformation, OutputSelectorInformation, SortOrderInformation };

use SDKBuilder\Event\PreProcessRequestEvent;

class ValidateItemFiltersListener
{
    /**
     * @param PreProcessRequestEvent $event
     * @throws ItemFilterException
     */
    public function onPreProcessRequest(PreProcessRequestEvent $event)
    {
        $itemFilterStorage = $event->getRequest()->getDynamicStorage();

        $foundFilters = $itemFilterStorage->getDynamicsInBulk(array('ExcludeSeller', 'Seller', 'TopRatedSellerOnly'), true);

        if (count($foundFilters) > 1) {
            throw new ItemFilterException('The ExcludeSeller item filter cannot be used together with either the Seller or TopRatedSellerOnly item filters or vice versa');
        }

        $foundFilters = $itemFilterStorage->getDynamicsInBulk(array('AvailableTo', 'LocatedIn'), true);

        if (count($foundFilters) > 1) {
            throw new ItemFilterException('AvailableTo item filter cannot be used together with LocatedIn item filter and vice versa');
        }

        if ($itemFilterStorage->hasDynamic('LocalSearchOnly') and $itemFilterStorage->isDynamicInRequest('LocalSearchOnly')) {
            $localSearchOnly = $itemFilterStorage->getDynamic('LocalSearchOnly');

            if ($localSearchOnly['value'] !== null) {
                $maxDistance = $itemFilterStorage->getDynamic('MaxDistance');
                $buyerPostalCode = $itemFilterStorage->getDynamic('BuyerPostalCode');

                if ($maxDistance['value'] === null or $buyerPostalCode['value'] === null) {
                    throw new ItemFilterException('LocalSearchOnly item filter has to be used together with MaxDistance item filter and buyerPostalCode');
                }
            }
        }

        if ($itemFilterStorage->hasDynamic('MaxDistance') and $itemFilterStorage->isDynamicInRequest('MaxDistance')) {
            $maxDistance = $itemFilterStorage->getDynamic('MaxDistance');

            if ($maxDistance['value'] !== null) {
                $buyerPostalCode = $itemFilterStorage->getDynamic('BuyerPostalCode');

                if ($buyerPostalCode['value'] === null) {
                    throw new ItemFilterException('MaxDistance item filter has to be used together with buyerPostalCode');
                }
            }
        }

        if ($itemFilterStorage->hasDynamic('FeedbackScoreMin') and
            $itemFilterStorage->hasDynamic('FeedbackScoreMax') and
            $itemFilterStorage->isDynamicInRequest('FeedbackScoreMin') and
            $itemFilterStorage->isDynamicInRequest('FeedbackScoreMax')
        )
        {
            $feedbackScoreMax = $itemFilterStorage->getDynamic('FeedbackScoreMax');
            $feedbackScoreMin = $itemFilterStorage->getDynamic('FeedbackScoreMin');

            if ($feedbackScoreMax['value'] < $feedbackScoreMin['value']) {
                throw new ItemFilterException('If provided, FeedbackScoreMax has to larger or equal than FeedbackScoreMin');
            }
        }

        if ($itemFilterStorage->hasDynamic('MaxBids') and
            $itemFilterStorage->hasDynamic('MinBids') and
            $itemFilterStorage->isDynamicInRequest('MaxBids') and
            $itemFilterStorage->isDynamicInRequest('MinBids')
        ) {
            $maxBids = $itemFilterStorage->getDynamic('MaxBids');
            $minBids = $itemFilterStorage->getDynamic('MinBids');

            if ($maxBids['value'] < $minBids['value']) {
                throw new ItemFilterException('If provided, MaxBids has to larger or equal than MinBids');
            }
        }

        if ($itemFilterStorage->hasDynamic('MaxQuantity') and $itemFilterStorage->hasDynamic('MinQuantity')) {
            $maxQuantity = $itemFilterStorage->getDynamic('MaxQuantity');
            $minQuantity = $itemFilterStorage->getDynamic('MinQuantity');

            if ($maxQuantity['value'] < $minQuantity['value']) {
                throw new ItemFilterException('If provided, MaxQuantity has to larger or equal than MinQuantity');
            }
        }

        if ($itemFilterStorage->hasDynamic('OutputSelector') and $itemFilterStorage->isDynamicInRequest('OutputSelector')) {
            $outputSelector = $itemFilterStorage->getDynamic('OutputSelector');

            foreach ($outputSelector['value'] as $selector) {
                if (!OutputSelectorInformation::instance()->has($selector)) {
                    throw new ItemFilterException('outputSelector \''.$selector.'\' is not supported by this version of FindingAPI. If ebay added it, add it manually in '.OutputSelectorInformation::class);
                }
            }

            if (in_array('ConditionHistogram', $outputSelector['value']) === true) {
                $globalId = strtolower($event->getRequest()->getGlobalParameters()->getParameter('global_id')->getValue());

                $validGlobalIds = array(
                    GlobalIdInformation::EBAY_MOTOR,
                    GlobalIdInformation::EBAY_IN,
                    GlobalIdInformation::EBAY_MY,
                    GlobalIdInformation::EBAY_PH,
                );

                if (in_array($globalId, $validGlobalIds) === true) {
                    throw new ItemFilterException('ConditionHistogram is supported for all eBay sites except US eBay Motors, India (IN), Malaysia (MY) and Philippines (PH)');
                }
            }
        }

        if ($itemFilterStorage->hasDynamic('SortOrder') and $itemFilterStorage->isDynamicInRequest('SortOrder')) {
            $sortOrder = $itemFilterStorage->getDynamic('SortOrder');

            if (is_array($sortOrder['value'])) {
                $sortOrderValue = $sortOrder['value'][0];

                if ($sortOrderValue === SortOrderInformation::BID_COUNT_FEWEST or $sortOrderValue === SortOrderInformation::BID_COUNT_MOST) {
                    if (!$itemFilterStorage->hasDynamic('ListingType') or !$itemFilterStorage->isDynamicInRequest('ListingType')) {
                        throw new ItemFilterException('To sort by bid count, you must specify a listing type filter to limit results to auction listings only (such as, & itemFilter.name=ListingType&itemFilter.value=Auction)');
                    }
                }
            }
        }
    }
}