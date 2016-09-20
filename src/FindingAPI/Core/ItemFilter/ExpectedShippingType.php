<?php

namespace FindingAPI\Core\ItemFilter;

use FindingAPI\Core\Exception\ItemFilterException;
use StrongType\ArrayType;

class ExpectedShippingType extends AbstractConstraint implements ConstraintInterface
{
    /**
     * @var ArrayType $itemFilters
     */
    private $itemFilters;
    /**
     * @param ArrayType $itemFilters
     */
    public function __construct($key, $value)
    {
        parent::__construct($key, $value);

        $this->itemFilters = new ArrayType($value);
    }

    /**
     * @throws ItemFilterException
     */
    public function checkConstraint()
    {
        if ($this->itemFilters->count() !== 1) {
            throw new ItemFilterException('Item filter ExpectedShippingType expects an array with values either Expedited or OneDayShipping');
        }

        $value = $this->itemFilters[0];

        if ($value !== 'OneDayShipping' and $value !== 'Expedited') {
            throw new ItemFilterException('Item filter ExpectedShippingType expects an array with values either Expedited or OneDayShipping');
        }
    }
}