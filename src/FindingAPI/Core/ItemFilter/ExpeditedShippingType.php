<?php

namespace FindingAPI\Core\ItemFilter;

class ExpeditedShippingType extends AbstractConstraint implements FilterInterface
{
    /**
     * @param array $filter
     * @return bool
     */
    public function validateFilter(array $filter) : bool
    {
        if (!$this->genericValidation($filter, 1)) {
            return false;
        }

        $validValues = array('Expedited', 'OneDayShipping');

        if (count($filter) > 1) {
            $this->exceptionMessages[] = $this->name.' can have an array with only one argument: '.implode(', ', $validValues);

            return false;
        }

        $value = $filter[0];

        if (in_array($value, $validValues) === false) {
            $this->exceptionMessages[] = $this->name.' can only accept values '.implode(', ', $validValues);

            return false;
        }

        return true;
    }
}