<?php

namespace FindingAPI\Core\ItemFilter;

use FindingAPI\Core\Exception\ItemFilterException;
use StrongType\ArrayType;

class ListingType extends AbstractConstraint implements ConstraintInterface
{
    /**
     * @var array $itemFilters
     */
    private $itemFilters = array('Auction', 'AuctionWithBIN', 'Classified', 'FixedPrice', 'All');
    /**
     * @param ArrayType $itemFilters
     */
    public function __construct($key, $value)
    {
        parent::__construct($key, $value);
    }
    /**
     * @throws ItemFilterException
     */
    public function checkConstraint()
    {
        $itemFilters = new ArrayType($this->itemFilters);

        if (!$itemFilters->inArray($this->value)) {
            throw new ItemFilterException('Item filter '.$this->key.' cannot contain a value '.$this->value.'. Allowed values are '.$itemFilters->implode(', '));
        }
    }
}