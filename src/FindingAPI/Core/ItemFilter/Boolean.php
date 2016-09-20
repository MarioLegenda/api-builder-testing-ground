<?php

namespace FindingAPI\Core\ItemFilter;

use FindingAPI\Core\Exception\ItemFilterException;
use StrongType\Exceptions\CriticalTypeException;
use StrongType\Boolean as StrongTypeBoolean;

class Boolean extends AbstractConstraint implements ConstraintInterface
{
    /**
     * @throws ItemFilterException
     */
    public function checkConstraint()
    {
        try {
            $boolean = new StrongTypeBoolean($this->value);
        } catch (CriticalTypeException $e) {
            if ($this->value !== 'true' and $this->value !== 'false') {
                throw new ItemFilterException('Item filter '.$this->key.' has to receive a boolean as a value or a string of \'true\' or \'false\'');
            }
        }
    }
}