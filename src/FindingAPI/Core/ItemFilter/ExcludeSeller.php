<?php

namespace FindingAPI\Core\ItemFilter;

use FindingAPI\Core\Exception\ItemFilterException;

class ExcludeSeller extends AbstractFilter implements FilterInterface
{
    /**
     * @return bool
     */
    public function validateFilter() : bool
    {
        if (count($this->filter) > 100) {
            $this->exceptionMessages[] = 'ExcludeSeller item filter can accept up to 100 seller names';

            return false;
        }

        foreach ($this->filter as $value) {
            if (!is_string($value)) {
                $this->exceptionMessages[] = 'ExcludeSeller accepts an array of seller names as a string';

                return false;
            }
        }

        return true;
    }
}