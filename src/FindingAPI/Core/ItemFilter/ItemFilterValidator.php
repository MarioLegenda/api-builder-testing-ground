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

                if ($itemFilter->validateFilter($itemFilterValue) !== true) {
                    throw new ItemFilterException((string) $itemFilter);
                }

                continue;
            }

            if (is_callable($validator)) {
                $valid = $validator->__invoke($name);

                if ($valid !== true) {
                    if (!is_string($valid)) {
                        throw new ItemFilterException('If you add a callable validator to a filter, validator must return either a boolean or a string that will be the exception message if validation has failed');
                    }

                    throw new ItemFilterException($valid);
                }

                continue;
            }

            throw new \RuntimeException('Unable to validate item filter '.$name.'. If you added a new filter or change an existing one, check you closure validator');
        }
    }
}