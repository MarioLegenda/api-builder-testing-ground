<?php

namespace FindingAPI\Core\Request;

use SDKBuilder\Request\AbstractValidator;
use FindingAPI\Core\Exception\ItemFilterException;

class ItemFiltersValidator extends AbstractValidator
{
    public function validate(): void
    {
        $itemFilterStorage = $this->getRequest()->getDynamicStorage();

        $addedItemFilters = $itemFilterStorage->filterAddedDynamics();

        foreach ($addedItemFilters as $name => $value) {
            $itemFilterData = $itemFilterStorage->getDynamic($name);

            $itemFilter = $itemFilterStorage->getDynamicInstance($name);
            $itemFilterValue = $itemFilterData['value'];

            if ($itemFilter->validateDynamic($itemFilterValue) !== true) {
                throw new ItemFilterException((string) $itemFilter);
            }
        }
    }
}