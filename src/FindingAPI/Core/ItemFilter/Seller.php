<?php

namespace FindingAPI\Core\ItemFilter;

class Seller extends AbstractConstraint implements FilterInterface
{
    /**
     * @param array $filter
     * @return bool
     */
    public function validateFilter(array $filter) : bool
    {
        if (!$this->genericValidation($filter)) {
            return false;
        }

        if (count($filter) > 100) {
            $this->exceptionMessages[] = $this->name.' has to be a valid seller name. Up to a 100 sellers can be specified';

            return false;
        }

        return true;
    }
}