<?php

namespace FindingAPI\Core\ItemFilter;

class BestOfferOnly extends BaseFindingDynamic
{
    /**
     * @return bool
     */
    public function validateDynamic() : bool
    {
        if (!$this->genericValidation($this->dynamicValue, 1)) {
            return false;
        }

        return parent::checkBoolean($this->dynamicValue[0]);
    }
}