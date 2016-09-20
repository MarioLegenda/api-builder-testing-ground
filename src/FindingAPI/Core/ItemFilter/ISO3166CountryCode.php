<?php

namespace FindingAPI\Core\ItemFilter;

class ISO3166CountryCode implements ConstraintInterface
{

    /**
     * @var string $value
     */
    private $value;
    /**
     * @var string $key
     */
    private $key;

    /**
     * @param string $value
     */
    public function __construct($key, $value)
    {
        $this->value = $value;
        $this->key = $key;
    }

    public function checkConstraint()
    {

    }
}