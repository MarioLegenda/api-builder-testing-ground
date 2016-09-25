<?php

namespace FindingAPI\Core\ItemFilter;

class PaginationInput extends AbstractConstraint implements FilterInterface
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

        $validValues = array('entriesPerPage', 'pageNumber');

        $filter = $filter[0];

        if (in_array($filter, $validValues) === false) {
            $this->exceptionMessages[] = 'PaginationInput can be only '.implode(', ', $validValues);

            return false;
        }

        return true;
    }
}