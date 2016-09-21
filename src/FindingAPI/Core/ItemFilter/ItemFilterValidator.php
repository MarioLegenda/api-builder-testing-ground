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
        foreach ($this->itemFilters as $name => $value) {
            $itemFilterData = $this->itemFilters->getItemFilter($name);

            $className = $itemFilterData['object'];
            $itemFilterValue = $itemFilterData['value'];

            if (is_string($className)) {
                $itemFilter = new $className($name);
            }

            if ($className instanceof AbstractConstraint and $className instanceof FilterInterface) {
                $itemFilter = $className;
            }

            if (!isset($itemFilter)) {
                throw new \RuntimeException('$itemFilter variable is not set. Debug: Class name: '.$className.'; Values: '.implode(', ', $value).' in ItemFilterValidator::validate()');
            }

            if (!$itemFilter->validateFilter($itemFilterValue)) {
                throw new ItemFilterException((string) $itemFilter);
            }
        }
    }
}