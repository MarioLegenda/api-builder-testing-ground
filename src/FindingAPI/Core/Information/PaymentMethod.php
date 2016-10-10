<?php

namespace FindingAPI\Core\Information;

class PaymentMethod
{
    const PAY_PAL = 'PayPal';
    const PAISA_PAL = 'PaisaPal';
    const PAISA_PAY_EMI = 'PaisaPayEmi';
    /**
     * @var array $sortOrders
     */
    private $paymentMethods = array(
        'PayPal',
        'PaisaPal',
        'PaisaPayEMI',
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
    public function has(string $method) : bool
    {
        return in_array($method, $this->paymentMethods) !== false;
    }
    /**
     * @param string $name
     * @param array $values
     * @return GlobalId
     */
    public function add(string $method)
    {
        if ($this->has($method)) {
            return null;
        }

        $this->paymentMethods[] = $method;

        return $this;
    }
    /**
     * @return array
     */
    public function getAll()
    {
        return $this->paymentMethods;
    }
}