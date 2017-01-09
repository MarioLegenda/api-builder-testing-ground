<?php

namespace FindingAPI\Core\ItemFilter;

use SDKBuilder\Dynamic\AbstractDynamic;
use SDKBuilder\Dynamic\DynamicInterface;

class MinQuantity extends AbstractDynamic implements DynamicInterface
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

        if (!is_int($filter)) {
            $this->exceptionMessages[] = $this->name.' has to be an integer greater than or equal to 1';

            return false;
        }

        if ($filter < 1) {
            $this->exceptionMessages[] = $this->name.' has to be an integer greater than or equal to 1';

            return false;
        }

        return true;
    }
}