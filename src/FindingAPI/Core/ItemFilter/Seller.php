<?php

namespace FindingAPI\Core\ItemFilter;

use SDKBuilder\Dynamic\AbstractDynamic;
use SDKBuilder\Dynamic\DynamicInterface;

class Seller extends AbstractDynamic
{
    /**
     * @return bool
     */
    public function validateDynamic() : bool
    {
        if (!$this->genericValidation($this->dynamicValue)) {
            return false;
        }

        if (count($this->dynamicValue) > 100) {
            $this->exceptionMessages[] = $this->name.' has to be a valid seller name. Up to a 100 sellers can be specified';

            return false;
        }

        return true;
    }
}