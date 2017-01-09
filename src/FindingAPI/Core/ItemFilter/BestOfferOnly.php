<?php

namespace FindingAPI\Core\ItemFilter;

use SDKBuilder\Dynamic\AbstractDynamic;
use SDKBuilder\Dynamic\DynamicInterface;

class BestOfferOnly extends AbstractDynamic implements DynamicInterface
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