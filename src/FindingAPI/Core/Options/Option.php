<?php

namespace FindingAPI\Core\Options;

class Option
{
    /**
     * @var string $name
     */
    private $name;
    /**
     * @var mixed $value
     */
    private $value;
    /**
     * Option constructor.
     * @param string $name
     * @param $value
     */
    public function __construct(string $name, bool $value)
    {
        $this->name = $name;
        $this->value = $value;
    }
    /**
     * @param string $name
     * @return Option
     */
    public function setName(string $name) : Option 
    {
        $this->name = $name;

        return $this;
    }
    /**
     * @return string
     */
    public function getName() : string 
    {
        return $this->name;
    }
    /**
     * @param bool $value
     * @return Option
     */
    public function setValue(bool $value) : Option 
    {
        $this->value = $value;

        return $this;
    }
    /**
     * @return mixed
     */
    public function getValue() 
    {
        return $this->value;
    }
}