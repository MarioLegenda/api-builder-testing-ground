<?php

namespace FindingAPI\Core\ItemFilter;

use SDKBuilder\Dynamic\AbstractDynamic;
use SDKBuilder\Dynamic\DynamicInterface;

class ExpeditedShippingType extends AbstractDynamic
{
    /**
     * @return bool
     */
    public function validateDynamic() : bool
    {
        if (!$this->genericValidation($this->dynamicValue, 1)) {
            return false;
        }

        $validValues = array('Expedited', 'OneDayShipping');

        if (count($this->dynamicValue) > 1) {
            $this->exceptionMessages[] = $this->name.' can have an array with only one argument: '.implode(', ', $validValues);

            return false;
        }

        $value = $this->dynamicValue[0];

        if (in_array($value, $validValues) === false) {
            $this->exceptionMessages[] = $this->name.' can only accept values '.implode(', ', $validValues);

            return false;
        }

        return true;
    }
}