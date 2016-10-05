<?php

namespace FindingAPI\Core\ItemFilter;

use FindingAPI\Processor\UrlifyInterface;

class AuthorizedSellerOnly extends AbstractConstraint implements FilterInterface
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