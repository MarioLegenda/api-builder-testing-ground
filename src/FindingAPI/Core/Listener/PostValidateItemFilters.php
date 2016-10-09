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
    }
}