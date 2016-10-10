<?php

namespace FindingAPI\Core\ItemFilter;

class MinBids extends AbstractFilter implements FilterInterface
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

        if ($filter < 0) {
            $this->exceptionMessages[] = $this->name.' has to be an integer greater than or equal to 0';

            return false;
        }

        return true;
    }
}