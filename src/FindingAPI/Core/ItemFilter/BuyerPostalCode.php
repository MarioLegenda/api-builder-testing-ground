<?php

namespace FindingAPI\Core\ItemFilter;

class BuyerPostalCode extends AbstractConstraint implements FilterInterface
{
    /**
     * @param array $filter
     * @return bool
     */
    public function validateFilter(array $filter) : bool
    {
        return true;
    }
}