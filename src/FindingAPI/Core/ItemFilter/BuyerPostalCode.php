<?php

namespace FindingAPI\Core\ItemFilter;

class BuyerPostalCode extends AbstractFilter implements FilterInterface
{
    /**
     * @return bool
     */
    public function validateFilter() : bool
    {
        return true;
    }
}