<?php

namespace FindingAPI\Core\ItemFilter;

class CharityOnly extends AbstractConstraint implements FilterInterface
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

        return parent::checkBoolean($filter[0]);
    }
}