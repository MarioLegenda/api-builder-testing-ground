<?php

namespace FindingAPI\Core\ItemFilter;

use FindingAPI\Processor\UrlifyInterface;

class AuthorizedSellerOnly extends AbstractConstraint implements FilterInterface, UrlifyInterface
{
    private $filter;
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

        $this->filter = $filter;

        return true;
    }
    /**
     * @param int $counter
     * @return string
     */
    public function urlify(int $counter) : string
    {
        return 'itemFilter('.$counter.').name='.$this->name.'&itemFilter('.$counter.').value='.$this->filter[0].'&';
    }
}