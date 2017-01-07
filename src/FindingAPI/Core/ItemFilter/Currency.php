<?php

namespace FindingAPI\Core\ItemFilter;

use FindingAPI\Core\Information\CurrencyInformation;

class Currency extends AbstractFilter implements FilterInterface
{
    /**
     * @return bool
     */
    public function validateFilter() : bool
    {
        if (!$this->genericValidation($this->filter, 1)) {
            return false;
        }

        $allowedCurrencies = CurrencyInformation::instance()->getAll();

        $currency = strtoupper($this->filter[0]);

        if (in_array($currency, $allowedCurrencies) === false) {
            $this->exceptionMessages[] = 'Invalid Currency item filter value supplied. Allowed currencies are '.implode(',', $allowedCurrencies);

            return false;
        }

        return true;
    }
}