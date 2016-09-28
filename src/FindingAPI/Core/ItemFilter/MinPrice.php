<?php

namespace FindingAPI\Core\ItemFilter;

use FindingAPI\Core\Helper;

class MinPrice extends AbstractConstraint implements FilterInterface
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

        if (!is_float($filter)) {
            $this->exceptionMessages[] = $this->name.' has to be an decimal greater than or equal to 0.0';

            return false;
        }

        if (Helper::compareFloatNumbers($filter, 0.0, '<')) {
            $this->exceptionMessages[] = $this->name.' has to be an decimal greater than or equal to 0.0';

            return false;
        }

        return true;
    }
}