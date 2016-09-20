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
     * @param array $itemFilters
     */
    public function __construct(array $itemFilters)
    {
        $this->itemFilters = $itemFilters;
    }

    /**
     * @void
     */
    public function validate()
    {
        foreach ($this->itemFilters as $name => $value) {
            $className = __NAMESPACE__.'\\'.$name;
            $itemFilter = new $className($name);

            if (!$itemFilter->validateFilter($value)) {
                throw new ItemFilterException((string) $itemFilter);
            }
        }
    }
}