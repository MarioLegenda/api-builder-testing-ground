<?php

namespace FindingAPI\Core\ItemFilter;


class MaxDistance extends AbstractConstraint implements FilterInterface
{
    /**
     * @param array $filter
     * @return bool
     */
    public function validateFilter(array $filter) : bool
    {
        /**
         *  TODO: After implementing buyer postal code, implement this item filter
         */
        return true;
    }
}