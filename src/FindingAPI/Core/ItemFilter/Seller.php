<?php

namespace FindingAPI\Core\ItemFilter;

class Seller extends AbstractFilter implements FilterInterface
{
    /**
     * @param array $filter
     * @return bool
     */
    public function validateFilter() : bool
    {
        if (!$this->genericValidation($this->filter)) {
            return false;
        }

        if (count($this->filter) > 100) {
            $this->exceptionMessages[] = $this->name.' has to be a valid seller name. Up to a 100 sellers can be specified';

            return false;
        }

        return true;
    }
}