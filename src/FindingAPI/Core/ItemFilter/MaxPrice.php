<?php

namespace FindingAPI\Core\ItemFilter;

use FindingAPI\Core\Helper;
use FindingAPI\Processor\UrlifyInterface;

class MaxPrice extends AbstractConstraint implements FilterInterface
{
    /**
     * @param array $filter
     * @return bool
     */
    public function validateFilter(array $filter) : bool
    {
        if (!$this->genericValidation($filter, 2)) {
            return false;
        }

        $toValidate = $filter[0];

        if (!is_float($toValidate)) {
            $this->exceptionMessages[] = $this->name.' has to be an decimal greater than or equal to 0.0';

            return false;
        }

        if (Helper::compareFloatNumbers($toValidate, 0.0, '<')) {
            $this->exceptionMessages[] = $this->name.' has to be an decimal greater than or equal to 0.0';

            return false;
        }

        return true;
    }
}