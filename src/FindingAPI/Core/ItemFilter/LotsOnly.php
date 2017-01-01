<?php

namespace FindingAPI\Core\ItemFilter;

class LotsOnly extends AbstractFilter implements FilterInterface
{
    /**
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