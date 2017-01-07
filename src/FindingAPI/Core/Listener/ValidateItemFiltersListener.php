<?php

namespace FindingAPI\Core\Listener;

use FindingAPI\Core\Exception\ItemFilterException;
use FindingAPI\Core\Information\GlobalId;
use FindingAPI\Core\Information\ListingType;
use FindingAPI\Core\Information\OutputSelector;
use FindingAPI\Core\Information\SortOrder;
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

        if ($itemFilterStorage->hasItemFilter('LocalSearchOnly') and $itemFilterStorage->isItemFilterInRequest('LocalSearchOnly')) {
            $localSearchOnly = $itemFilterStorage->getItemFilter('LocalSearchOnly');

            if ($localSearchOnly['value'] !== null) {
                $maxDistance = $itemFilterStorage->getItemFilter('MaxDistance');
                $buyerPostalCode = $itemFilterStorage->getItemFilter('BuyerPostalCode');

                if ($maxDistance['value'] === null or $buyerPostalCode['value'] === null) {
                    throw new ItemFilterException('LocalSearchOnly item filter has to be used together with MaxDistance item filter and buyerPostalCode');
                }
            }
        }

        if ($itemFilterStorage->hasItemFilter('MaxDistance') and $itemFilterStorage->isItemFilterInRequest('MaxDistance')) {
            $maxDistance = $itemFilterStorage->getItemFilter('MaxDistance');

            if ($maxDistance['value'] !== null) {
                $buyerPostalCode = $itemFilterStorage->getItemFilter('BuyerPostalCode');

                if ($buyerPostalCode['value'] === null) {
                    throw new ItemFilterException('MaxDistance item filter has to be used together with buyerPostalCode');
                }
            }
        }

        if ($itemFilterStorage->hasItemFilter('FeedbackScoreMin') and
            $itemFilterStorage->hasItemFilter('FeedbackScoreMax') and
            $itemFilterStorage->isItemFilterInRequest('FeedbackScoreMin') and
            $itemFilterStorage->isItemFilterInRequest('FeedbackScoreMax')
        )
        {
            $feedbackScoreMax = $itemFilterStorage->getItemFilter('FeedbackScoreMax');
            $feedbackScoreMin = $itemFilterStorage->getItemFilter('FeedbackScoreMin');

            if ($feedbackScoreMax['value'] < $feedbackScoreMin['value']) {
                throw new ItemFilterException('If provided, FeedbackScoreMax has to larger or equal than FeedbackScoreMin');
            }
        }

        if ($itemFilterStorage->hasItemFilter('MaxBids') and
            $itemFilterStorage->hasItemFilter('MinBids') and
            $itemFilterStorage->isItemFilterInRequest('MaxBids') and
            $itemFilterStorage->isItemFilterInRequest('MinBids')
        ) {
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

        if ($itemFilterStorage->hasItemFilter('OutputSelector') and $itemFilterStorage->isItemFilterInRequest('OutputSelector')) {
            $outputSelector = $itemFilterStorage->getItemFilter('OutputSelector');

            foreach ($outputSelector['value'] as $selector) {
                if (!OutputSelector::instance()->has($selector)) {
                    throw new ItemFilterException('outputSelector \''.$selector.'\' is not supported by this version of FindingAPI. If ebay added it, add it manually in '.OutputSelector::class);
                }
            }

            if (in_array('ConditionHistogram', $outputSelector['value']) === true) {
                $globalId = strtolower($event->getRequest()->getGlobalParameters()->getParameter('global_id')->getValue());

                $validGlobalIds = array(
                    GlobalId::EBAY_MOTOR,
                    GlobalId::EBAY_IN,
                    GlobalId::EBAY_MY,
                    GlobalId::EBAY_PH,
                );

                if (in_array($globalId, $validGlobalIds) === true) {
                    throw new ItemFilterException('ConditionHistogram is supported for all eBay sites except US eBay Motors, India (IN), Malaysia (MY) and Philippines (PH)');
                }
            }
        }

        if ($itemFilterStorage->hasItemFilter('SortOrder') and $itemFilterStorage->isItemFilterInRequest('SortOrder')) {
            $sortOrder = $itemFilterStorage->getItemFilter('SortOrder');

            if (is_array($sortOrder['value'])) {
                $sortOrderValue = $sortOrder['value'][0];

                if ($sortOrderValue === SortOrder::BID_COUNT_FEWEST or $sortOrderValue === SortOrder::BID_COUNT_MOST) {
                    if (!$itemFilterStorage->hasItemFilter('ListingType') or !$itemFilterStorage->isItemFilterInRequest('ListingType')) {
                        throw new ItemFilterException('To sort by bid count, you must specify a listing type filter to limit results to auction listings only (such as, & itemFilter.name=ListingType&itemFilter.value=Auction)');
                    }
                }
            }
        }
    }
}