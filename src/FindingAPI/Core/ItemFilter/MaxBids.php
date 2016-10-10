<?php

namespace FindingAPI\Core\ItemFilter;

class MaxBids extends AbstractFilter implements FilterInterface
{
    /**
     * @param array $filter
     * @return bool
     */
    public function validateFilter() : bool
    {
        if (!$this->genericValidation($this->filter, 1)) {
            return false;
        }

        $filter = $this->filter[0];

        if ($filter < 0 or !is_int($filter)) {
            $this->exceptionMessages[] = $this->name.' has to be an integer greater that or equal to 1';

            return false;
        }

        return true;
    }
}