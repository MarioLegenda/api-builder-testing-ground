<?php

namespace FindingAPI\Core\ItemFilter;

use SDKBuilder\Dynamic\AbstractDynamic;
use SDKBuilder\Dynamic\DynamicInterface;

class MinBids extends AbstractDynamic
{
    /**
     * @return bool
     */
    public function validateDynamic() : bool
    {
        if (!$this->genericValidation($this->dynamicValue, 1)) {
            return false;
        }

        $filter = $this->dynamicValue[0];

        if ($filter < 0) {
            $this->exceptionMessages[] = $this->name.' has to be an integer greater than or equal to 0';

            return false;
        }

        return true;
    }
}