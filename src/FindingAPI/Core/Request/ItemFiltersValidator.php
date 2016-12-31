<?php

namespace FindingAPI\Core\Request;

use SDKBuilder\Request\AbstractValidator;
use FindingAPI\Core\Exception\ItemFilterException;

class ItemFiltersValidator extends AbstractValidator
{
    public function validate(): void
    {
        $itemFilterStorage = $this->getRequest()->getItemFilterStorage();

        $addedItemFilters = $itemFilterStorage->filterAddedFilter(array('SortOrder', 'PaginationInput'));

        foreach ($addedItemFilters as $name => $value) {
            $itemFilterData = $itemFilterStorage->getItemFilter($name);

            $itemFilter = $itemFilterStorage->getItemFilterInstance($name);
            $itemFilterValue = $itemFilterData['value'];

            if ($itemFilter->validateFilter($itemFilterValue) !== true) {
                throw new ItemFilterException((string) $itemFilter);
            }
        }
    }
}