<?php

namespace FindingAPI\Core\ItemFilter;

use FindingAPI\Core\Information\PaymentMethodInformation;
use SDKBuilder\Dynamic\AbstractDynamic;
use SDKBuilder\Dynamic\DynamicInterface;

class PaymentMethod extends AbstractDynamic implements DynamicInterface
{
    /**
     * @return bool
     */
    public function validateDynamic() : bool
    {
        if (!$this->genericValidation($this->dynamicValue, 1)) {
            return false;
        }

        $filter = $this->dynamicValue[0];

        if (!PaymentMethodInformation::instance()->has($filter)) {
            $this->exceptionMessages[] = $this->name.' has no payment method '.$filter.'. Allowed payment methods are '.implode(', ', PaymentMethodInformation::instance()->getAll());

            return false;
        }

        return true;
    }
}