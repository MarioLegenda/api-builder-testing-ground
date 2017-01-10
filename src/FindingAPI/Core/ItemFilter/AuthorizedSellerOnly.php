<?php

namespace FindingAPI\Core\ItemFilter;

class AuthorizedSellerOnly extends BaseFindingDynamic
{
    /**
     * @return bool
     */
    public function validateDynamic() : bool
    {
        if (!$this->genericValidation($this->dynamicValue, 1)) {
            return false;
        }

        if (parent::checkBoolean($this->dynamicValue[0]) === false) {
            return false;
        }

        return true;
    }
}