<?php

namespace FindingAPI\Core\ItemFilter;

class ExcludeCategory extends BaseFindingDynamic
{
    /**
     * @return bool
     */
    public function validateDynamic() : bool
    {
        if (count($this->dynamicValue) > 25) {
            $this->exceptionMessages[] = 'ExcludeCategory item filter can accept up to 25 category ids';

            return false;
        }

        foreach ($this->dynamicValue as $value) {
            if (!is_numeric($value)) {
                $this->exceptionMessages['Value '.$value.' has to be a valid category number or a numeric string'];

                return false;
            }
        }

        return true;
    }
}