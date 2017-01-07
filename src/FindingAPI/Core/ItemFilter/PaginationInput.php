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
        foreach ($filter as $key => $f) {
            if (in_array($key, $validValues) === false) {
                $this->exceptionMessages[] = 'Invalid paginationInput entry \''.$key.'\'. Valid entries are '.implode(', ', $validValues);

                return false;
            }
        }

        return true;
    }
    /**
     * @param int $counter
     * @return string
     */
    public function urlify(int $counter): string
    {
        $finalEntry = '';

        foreach ($this->filter[0] as $key => $f) {
            $finalEntry.='paginationInput.'.$key.'='.$f.'&';
        }

        return $finalEntry;
    }
}