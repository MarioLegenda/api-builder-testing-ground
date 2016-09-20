<?php

namespace FindingAPI\Core\ItemFilter;

use FindingAPI\Core\Exception\ItemFilterException;
use FindingAPI\Core\ItemFilter;
use StrongType\ArrayType;

class ExcludeSeller extends AbstractConstraint implements ConstraintInterface
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
        if ($this->itemFilters->keyExists(ItemFilter::SELLER) and $this->itemFilters->keyExists(ItemFilter::TOP_RATED_SELLER_ONLY)) {
            throw new ItemFilterException('Item filter ExcludeSeller cannot be used together with Seller or TopRatedSellerOnly');
        }
    }
}