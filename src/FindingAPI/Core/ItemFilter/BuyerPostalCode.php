<?php

namespace FindingAPI\Core\ItemFilter;

class BuyerPostalCode extends BaseFindingDynamic
{
    /**
     * @return bool
     */
    public function validateDynamic() : bool
    {
        return true;
    }
}