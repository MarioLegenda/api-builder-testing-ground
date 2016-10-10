<?php

namespace FindingAPI\Core\ItemFilter;

class BuyerPostalCode extends AbstractFilter implements FilterInterface
{
    /**
     * @param array $filter
     * @return bool
     */
    public function validateFilter() : bool
    {
        return true;
    }
}