<?php

namespace FindingAPI\Core\ItemFilter;

class LocatedIn extends AbstractConstraint implements FilterInterface
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

        if (count($filter) > 25) {
            $this->exceptionMessages[] = $this->name.' can specify up to 25 countries. '.count($filter).' given';

            return false;
        }
        
        
    }
}