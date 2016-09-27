<?php

namespace FindingAPI\Core\Information;

use FindingAPI\Core\Exception\ItemFilterException;

class Currency
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
     * @var array $currencies
     */
    private $currencies = array(
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
        'twd',
        'usd',
    );

    /**
     * @var GlobalId $instance
     */
    private static $instance;
    /**
     * @return GlobalId
     */
    public static function instance()
    {
        self::$instance = (self::$instance instanceof self) ? self::$instance : new self();

        return self::$instance;
    }
    /**
     * @param string $id
     * @return mixed
     */
    public function has(string $currency) : bool
    {
        if ($currency === 'SomeNewCurrency') {
            //var_dump(self::$instance->currencies);
            //die("kreten");
        }

        return in_array($currency, $this->currencies) !== false;
    }
    /**
     * @param string $name
     * @param array $values
     * @return GlobalId
     * @throws ItemFilterException
     */
    public function add(string $currency)
    {
        if ($this->has($currency)) {
            return null;
        }

        $this->currencies[] = $currency;

        return self::$instance;
    }
    /**
     * @return array
     */
    public function getAll()
    {
        return $this->currencies;
    }
}