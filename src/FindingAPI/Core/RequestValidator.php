<?php

namespace FindingAPI\Core;

use FindingAPI\Core\Exception\FindingApiException;
use FindingAPI\Core\Exception\ItemFilterException;
use FindingAPI\Core\Request;
use Symfony\Component\Yaml\Yaml;
use StrongType\ArrayType;

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
        $itemFilters = $this->request->getItemFilterStorage();
        $definitions = $this->request->getDefinitions();

        if (empty($definitions)) {
            throw new FindingApiException('You have\'t specified any search words');
        }

        $addedItemFilters = $itemFilters->filterAddedFilter();

        foreach ($addedItemFilters as $name => $value) {
            $itemFilterData = $itemFilters->getItemFilter($name);

            $itemFilter = $itemFilters->getItemFilterInstance($name);
            $itemFilterValue = $itemFilterData['value'];

            if ($itemFilter->validateFilter($itemFilterValue) !== true) {
                throw new ItemFilterException((string) $itemFilter);
            }
        }
    }
}