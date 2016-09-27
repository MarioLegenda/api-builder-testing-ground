<?php

namespace FindingAPI\Core\ItemFilter;

class MaxPrice extends AbstractConstraint implements FilterInterface
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

        $filter = $filter[0];

        $dotSplitted = explode('.', $filter);

        if (count($dotSplitted) === 1) {
            $this->exceptionMessages[] = $this->name.' should receive a decimal number with one decimal after .';

            return false;
        }

        return true;
    }
}