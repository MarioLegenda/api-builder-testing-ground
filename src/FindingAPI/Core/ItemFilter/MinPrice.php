<?php

namespace FindingAPI\Core\ItemFilter;

use FindingAPI\Core\Helper;

class MinPrice extends AbstractFilter implements FilterInterface
{
    /**
     * @return bool
     */
    public function validateFilter() : bool
    {
        if (!$this->genericValidation($this->filter, 2)) {
            return false;
        }

        $toValidate = $this->filter[0];

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