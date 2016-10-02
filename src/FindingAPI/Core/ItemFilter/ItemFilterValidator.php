<?php

namespace FindingAPI\Core\ItemFilter;

use FindingAPI\Core\Exception\ItemFilterException;
use Symfony\Component\Yaml\Yaml;
use StrongType\ArrayType;

class ItemFilterValidator
{
    /**
     * @var array $itemFilters
     */
    private $itemFilters;
    /**
     * ItemFilterProcessor constructor.
     * @param ItemFilterStorage $itemFilters
     */
    public function __construct(ItemFilterStorage $itemFilters)
    {
        $this->itemFilters = $itemFilters;
    }
    /**
     * @void
     */
    public function validate()
    {
        $addedItemFilters = $this->itemFilters->filterAddedFilter();

        foreach ($addedItemFilters as $name => $value) {
            $itemFilterData = $this->itemFilters->getItemFilter($name);

            $validator = $itemFilterData['object'];
            $itemFilterValue = $itemFilterData['value'];

            if (is_string($validator)) {
                $itemFilter = new $validator($name);
            }

            if (is_callable($validator)) {
                $validator->__invoke($name);
            }

            if (!isset($itemFilter)) {
                throw new \RuntimeException('$itemFilter variable is not set. Debug: Validator type: '.gettype($validator).'; Values: '.implode(', ', $value).' in ItemFilterValidator::validate()');
            }

            if (!$itemFilter->validateFilter($itemFilterValue)) {
                throw new ItemFilterException((string) $itemFilter);
            }
        }
    }
}