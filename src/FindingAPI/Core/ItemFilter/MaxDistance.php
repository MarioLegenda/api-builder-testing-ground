<?php

namespace FindingAPI\Core\ItemFilter;

class MaxDistance extends AbstractFilter implements FilterInterface
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

        if ($filter < 5) {
            $this->exceptionMessages[] = $this->name.' has to be a number greater than or equal to 5';

            return false;
        }

        return true;
    }
}