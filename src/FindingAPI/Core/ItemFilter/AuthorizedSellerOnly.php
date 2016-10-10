<?php

namespace FindingAPI\Core\ItemFilter;

class AuthorizedSellerOnly extends AbstractFilter implements FilterInterface
{
    /**
     * @param array $filter
     * @return bool
     */
    public function validateFilter() : bool
    {
        if (!$this->genericValidation($this->filter, 1)) {
            return false;
        }

        if (parent::checkBoolean($this->filter[0]) === false) {
            return false;
        }

        return true;
    }
}