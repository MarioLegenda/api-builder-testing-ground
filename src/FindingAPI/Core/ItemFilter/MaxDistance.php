<?php

namespace FindingAPI\Core\ItemFilter;

class MaxDistance extends BaseFindingDynamic
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

        if ($filter < 5) {
            $this->exceptionMessages[] = $this->name.' has to be a number greater than or equal to 5';

            return false;
        }

        return true;
    }
}