<?php

namespace FindingAPI\Core\ItemFilter;

use FindingAPI\Core\Exception\FindingApiException;
use StrongType\Boolean;
use StrongType\Exceptions\CriticalTypeException;

abstract class AbstractConstraint
{
    /**
     * @var string $name
     */
    protected $name;
    /**
     * @var array $exceptionMessages
     */
    protected $exceptionMessages = array();
    /**
     * @oaran string $key
     * @param string $value
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }
    /**
     * @return string
     */
    public function __toString() : string
    {
        if (empty($this->exceptionMessages)) {
            return 'There are no exception messages for '.$this->name.' but there should be.';
        }

        return 'Errors: '.implode(', ', $this->exceptionMessages);
    }

    protected function genericValidation(array $value, $count = null) : bool
    {
        if (empty($value)) {
            $this->exceptionMessages['Argument for item filter '.$this->name.' cannot be empty.'];
        }

        if ($count !== null) {
            if (count($value) < $count) {
                $this->exceptionMessages[] = $this->name.' can receive an array argument with only one value';

                return false;
            }
        }

        return true;
    }

    protected function checkBoolean($value) : bool
    {
        try {
            new Boolean($value);
        } catch (CriticalTypeException $e) {
            $this->exceptionMessages[] = $this->name.' can only accept true or false boolean values';

            return false;
        }

        return true;
    }
}