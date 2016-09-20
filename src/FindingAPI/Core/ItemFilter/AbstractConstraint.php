<?php

namespace FindingAPI\Core\ItemFilter;

abstract class AbstractConstraint
{
    /**
     * @var array $value
     */
    protected $value;
    /**
     * @var string $key
     */
    protected $key;
    /**
     * @oaran string $key
     * @param string $value
     */
    public function __construct($key, $value)
    {
        $this->value = $value;
        $this->key = $key;
    }
}