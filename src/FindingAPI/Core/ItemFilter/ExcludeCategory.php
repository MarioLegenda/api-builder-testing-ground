<?php

namespace FindingAPI\Core\ItemFilter;

use FindingAPI\Core\Exception\ItemFilterException;

class ExcludeCategory extends AbstractConstraint implements FilterInterface
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

        foreach ($filter as $value) {
            if (!is_numeric($value)) {
                $this->exceptionMessages['Value '.$value.' has to be a valid category number or a numeric string'];

                return false;
            }
        }

        return true;
    }
}