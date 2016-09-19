<?php

namespace FindingAPI\Core;

use FindingAPI\Core\Exception\ItemFilterException;

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
            $method = lcfirst($name);

            $this->{$method}($value);
        }
    }
    /**
     * @param string $name
     * @param array $values
     * @return bool
     * @throws ItemFilterException
     */
    private function authorizedSellerOnly(array $values) : bool
    {
        $exceptionMessage = 'AuthorizedSeller only can accept only true or false boolean values and can be an array with one value';

        $this->authorizeBoolean($values, $exceptionMessage);

        return true;
    }

    private function authorizeBoolean(array $values, string $exceptionMessage)
    {
        if (count($values) !== 1) {
            throw new ItemFilterException($exceptionMessage);
        }

        if (!is_bool($values[0])) {
            throw new ItemFilterException($exceptionMessage);
        }
    }
}