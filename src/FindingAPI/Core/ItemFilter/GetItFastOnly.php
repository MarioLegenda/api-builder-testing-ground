<?php

namespace FindingAPI\Core\ItemFilter;

class GetItFastOnly extends AbstractFilter implements FilterInterface
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

        return parent::checkBoolean($this->filter[0]);
    }
}