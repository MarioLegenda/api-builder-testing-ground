<?php

namespace FindingAPI\Core;

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

        $this->validateExcludeSellerAndOthers($itemFilterStorage);

        foreach ($addedItemFilters as $name => $value) {
            $itemFilterData = $itemFilterStorage->getItemFilter($name);

            $itemFilter = $itemFilterStorage->getItemFilterInstance($name);
            $itemFilterValue = $itemFilterData['value'];

            if ($itemFilter->validateFilter($itemFilterValue) !== true) {
                throw new ItemFilterException((string) $itemFilter);
            }
        }
    }

    private function validateExcludeSellerAndOthers(ItemFilterStorage $itemFilterStorage)
    {
        // Validate that only one of ExcludeSeller, Seller and TopRatedSellerOnly exists

        $foundFilters = $itemFilterStorage->getItemFiltersInBulk(array('ExcludeSeller', 'Seller', 'TopRatedSellerOnly'), true);

        if (count($foundFilters) > 1) {
            throw new ItemFilterException('The ExcludeSeller item filter cannot be used together with either the Seller or TopRatedSellerOnly item filters or vice versa');
        }
    }
}