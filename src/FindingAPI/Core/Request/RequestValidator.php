<?php

namespace FindingAPI\Core\Request;

use FindingAPI\Core\Exception\FindingApiException;
use FindingAPI\Core\Exception\ItemFilterException;
use FindingAPI\Core\ItemFilter\ItemFilterStorage;

class RequestValidator
{
    /**
     * @var array $itemFilters
     */
    private $request;
    /**
     * ItemFilterProcessor constructor.
     * @param Request $itemFilters
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    /**
     * @void
     */
    public function validate()
    {
        $itemFilterStorage = $this->request->getItemFilterStorage();
        $definitions = $this->request->getDefinitions();

        if (empty($definitions)) {
            throw new FindingApiException('You have\'t specified any search words');
        }

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