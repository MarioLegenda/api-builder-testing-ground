<?php

namespace FindingAPI\Core\ItemFilter;

use FindingAPI\Core\Exception\ItemFilterException;

class FutureDateTime extends AbstractConstraint implements ConstraintInterface
{
    /**
     * @throws ItemFilterException
     */
    public function checkConstraint()
    {
        if (!$this->value instanceof \DateTime) {
            throw new ItemFilterException('Invalid value supplied for '.$this->key.' Value has to be a DateTime instance in the future');
        }

        $currentDateTime = new \DateTime();

        if ($this->value < $currentDateTime or $this->value === $currentDateTime) {
            throw new ItemFilterException('Invalid value supplied for '.$this->key.' value has to be a DateTime instance in the future');
        }
    }
}