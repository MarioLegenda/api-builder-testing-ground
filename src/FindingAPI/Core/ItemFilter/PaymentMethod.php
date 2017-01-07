<?php

namespace FindingAPI\Core\ItemFilter;

use FindingAPI\Core\Information\PaymentMethodInformation;

class PaymentMethod extends AbstractFilter implements FilterInterface
{
    /**
     * @return bool
     */
    public function validateFilter() : bool
    {
        if (!$this->genericValidation($this->filter, 1)) {
            return false;
        }

        $filter = $this->filter[0];

        if (!PaymentMethodInformation::instance()->has($filter)) {
            $this->exceptionMessages[] = $this->name.' has no payment method '.$filter.'. Allowed payment methods are '.implode(', ', PaymentMethodInformation::instance()->getAll());

            return false;
        }

        return true;
    }
}