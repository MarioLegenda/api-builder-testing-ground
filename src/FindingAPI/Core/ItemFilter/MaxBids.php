<?php

namespace FindingAPI\Core\ItemFilter;

class MaxBids extends AbstractConstraint implements FilterInterface
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

        $filter = $filter[0];

        if ($filter < 0 or !is_int($filter)) {
            $this->exceptionMessages[] = $this->name.' has to be an integer greater that or equal to 1';

            return false;
        }

        return true;
    }
}