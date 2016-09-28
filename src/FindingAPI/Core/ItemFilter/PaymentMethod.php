<?php

namespace FindingAPI\Core\ItemFilter;

use FindingAPI\Core\Information\PaymentMethod as PaymentMethodInformation;

class PaymentMethod extends AbstractConstraint implements FilterInterface
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

        if (!PaymentMethodInformation::instance()->has($filter)) {
            $this->exceptionMessages[] = $this->name.' has no payment method '.$filter.'. Allowed payment methods are '.implode(', ', PaymentMethodInformation::instance()->getAll());

            return false;
        }

        return true;
    }
}