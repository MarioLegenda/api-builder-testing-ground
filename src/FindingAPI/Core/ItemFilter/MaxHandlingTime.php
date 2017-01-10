<?php

namespace FindingAPI\Core\ItemFilter;

class MaxHandlingTime extends BaseFindingDynamic
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

        if ($filter < 1 or !is_int($filter)) {
            $this->exceptionMessages[] = $this->name.' has to be an integer greater that or equal to 1';

            return false;
        }

        return true;
    }
}