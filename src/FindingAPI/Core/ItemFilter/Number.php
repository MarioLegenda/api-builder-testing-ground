<?php

namespace FindingAPI\Core\ItemFilter;

use FindingAPI\Core\Exception\ItemFilterException;

class Number extends AbstractConstraint implements ConstraintInterface
{
    public function checkConstraint()
    {
        if (!is_numeric($this->value)) {
            throw new ItemFilterException('Item filter '.$this->key.'has to be a number');
        }

        if ($this->value < 0) {
            throw new ItemFilterException('Item filter '.$this->key.'has to be greater than or equal to zero');
        }
    }
}