<?php

namespace Test\ItemFilter;

use FindingAPI\Core\ItemFilter\AbstractConstraint;
use FindingAPI\Core\ItemFilter\FilterInterface;

class SingleValueItemFilter extends AbstractConstraint implements FilterInterface
{
    /**
     * @param array $filter
     * @return bool
     */
    public function validateFilter(array $filter) : bool
    {
        if (!$this->genericValidation($filter, 1)) {
            return false;
        }

        if (parent::checkBoolean($filter[0]) === false) {
            return false;
        }

        return true;
    }
}