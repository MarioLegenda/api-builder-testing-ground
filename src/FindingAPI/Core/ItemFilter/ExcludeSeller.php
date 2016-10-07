<?php

namespace FindingAPI\Core\ItemFilter;

use FindingAPI\Core\Exception\ItemFilterException;
use FindingAPI\Core\ItemFilter;

class ExcludeSeller extends AbstractConstraint implements FilterInterface
{
    /**
     * @throws ItemFilterException
     * @return bool
     */
    public function validateFilter(array $filter) : bool
    {
        if (!$this->genericValidation($filter, 1)) {
            return false;
        }

        if (count($filter) > 100) {
            $this->exceptionMessages[] = 'ExcludeSeller item filter can accept up to 100 seller names';

            return false;
        }

        foreach ($filter as $value) {
            if (!is_string($value)) {
                $this->exceptionMessages[] = 'ExcludeSeller accepts an array of seller names as a string';

                return false;
            }
        }

        return true;
    }

    /**
     * @param int $counter
     * @return string
     */
    public function urlify(int $counter) : string
    {
        $toBeAppended = 'itemFilter('.$counter.').name='.$this->name;

        $internalCounter = 0;
        foreach ($this->filter as $filter) {
            $toBeAppended.='&itemFilter('.$counter.').value('.$internalCounter.')='.$filter;

            $internalCounter++;
        }

        return $toBeAppended.'&';
    }
}