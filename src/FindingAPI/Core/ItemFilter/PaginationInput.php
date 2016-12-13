<?php

namespace FindingAPI\Core\ItemFilter;

class PaginationInput extends AbstractFilter implements FilterInterface
{
    /**
     * @return bool
     */
    public function validateFilter() : bool
    {
        if (!$this->genericValidation($this->filter, 1)) {
            return false;
        }

        $validValues = array('entriesPerPage', 'pageNumber');

        $filter = $this->filter[0];

        if (in_array($filter, $validValues) === false) {
            $this->exceptionMessages[] = 'PaginationInput can be only '.implode(', ', $validValues);

            return false;
        }

        return true;
    }
}