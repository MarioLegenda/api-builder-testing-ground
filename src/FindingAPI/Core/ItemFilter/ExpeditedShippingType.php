<?php

namespace FindingAPI\Core\ItemFilter;

class ExpeditedShippingType extends AbstractFilter implements FilterInterface
{
    /**
     * @return bool
     */
    public function validateFilter() : bool
    {
        if (!$this->genericValidation($this->filter, 1)) {
            return false;
        }

        $validValues = array('Expedited', 'OneDayShipping');

        if (count($this->filter) > 1) {
            $this->exceptionMessages[] = $this->name.' can have an array with only one argument: '.implode(', ', $validValues);

            return false;
        }

        $value = $this->filter[0];

        if (in_array($value, $validValues) === false) {
            $this->exceptionMessages[] = $this->name.' can only accept values '.implode(', ', $validValues);

            return false;
        }

        return true;
    }
}