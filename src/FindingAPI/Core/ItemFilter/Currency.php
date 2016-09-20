<?php

namespace FindingAPI\Core\ItemFilter;

use FindingAPI\Core\Exception\ItemFilterException;
use StrongType\ArrayType;

class Currency extends AbstractConstraint implements ConstraintInterface
{
    const AUSTRALIAN = 'aud';
    const CANADIAN = 'cad';
    const SWISS = 'chf';
    const CHINESE = 'cny';
    const EURO = 'eur';
    const BRITISH = 'gbp';
    const HONG_KONG = 'hkd';
    const INDIAN = 'inr';
    const MALAYSIAN = 'myr';
    const PHILIPPINES = 'php';
    const POLAND = 'pln';
    const SWEDISH = 'sek';
    const TAIWAN = 'twd';
    const USA = 'usd';

    /**
     * @var ArrayType $allowedCurrencies
     */
    private $allowedCurrencies;
    /**
     * @param string $key
     * @param string $value
     */
    public function __construct($key, $value)
    {
        parent::__construct($key, $value);

        $this->allowedCurrencies = new ArrayType(array(
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
    }
    /**
     * @throws ItemFilterException
     */
    public function checkConstraint()
    {
        $curreny = strtolower($this->value);

        if (!$this->allowedCurrencies->inArray($curreny)) {
            throw new ItemFilterException('Invalid currency supplied. Allowed currencies are '.implode(',', $this->allowedCurrencies));
        }
    }
}