<?php

namespace FindingAPI\Core\Information;

use FindingAPI\Core\Exception\ItemFilterException;

class CurrencyInformation
{
    const AUSTRALIAN = 'AUD';
    const CANADIAN = 'CAD';
    const SWISS = 'CHF';
    const CHINESE = 'CNY';
    const EURO = 'EUR';
    const BRITISH = 'GBP';
    const HONG_KONG = 'HKD';
    const INDIAN = 'INR';
    const MALAYSIAN = 'MYR';
    const PHILIPPINES = 'PHP';
    const POLAND = 'PLN';
    const SWEDISH = 'SEK';
    const TAIWAN = 'TWD';
    const USA = 'USD';
    /**
     * @var array $currencies
     */
    private $currencies = array(
        'AUD',
        'CAD',
        'CHR',
        'CNY',
        'EUR',
        'GBP',
        'HKD',
        'INR',
        'MYR',
        'PHP',
        'PLN',
        'SEK',
        'TWD',
        'USD',
    );
    /**
     * @var CurrencyInformation $instance
     */
    private static $instance;
    /**
     * @return CurrencyInformation
     */
    public static function instance()
    {
        self::$instance = (self::$instance instanceof self) ? self::$instance : new self();

        return self::$instance;
    }
    /**
     * @param string $currency
     * @return mixed
     */
    public function has(string $currency) : bool
    {
        return in_array($currency, $this->currencies) !== false;
    }
    /**
     * @param $currency
     * @return CurrencyInformation
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