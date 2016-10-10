<?php

namespace FindingAPI\Core\ItemFilter;

use StrongType\ArrayType;

class Currency extends AbstractFilter implements FilterInterface
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

        $allowedCurrencies = new ArrayType(array(
            'aud',
            'cad',
            'chf',
            'cny',
            'eur',
            'gbp',
            'hkd',
            'inr',
            'myr',
            'php',
            'pln',
            'sek',
            'sgd',
            'twd',
            'usd',
        ));

        $currency = strtolower($this->filter[0]);

        if (!$allowedCurrencies->inArray($currency)) {
            $this->exceptionMessages[] = 'Invalid Currency item filter value supplied. Allowed currencies are '.implode(',', $allowedCurrencies);

            return false;
        }

        return true;
    }
}