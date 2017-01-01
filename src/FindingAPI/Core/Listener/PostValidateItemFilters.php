<?php

namespace FindingAPI\Core\Listener;

use FindingAPI\Core\Event\ItemFilterEvent;
use FindingAPI\Core\Exception\ItemFilterException;

class PostValidateItemFilters
{
    /**
     * @param ItemFilterEvent $event
     */
    public function onPostValidate(ItemFilterEvent $event)
    {
        $itemFilterStorage = $event->getItemFilterStorage();

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