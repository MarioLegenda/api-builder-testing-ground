<?php

namespace FindingAPI\Core\ItemFilter;

class FeedbackScoreMin extends AbstractConstraint implements FilterInterface
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

        if (count($filter) !== 1) {
            $this->exceptionMessages[] = $this->name.' can only have one value in the argument array';

            return false;
        }

        if (is_bool($filter[0])) {
            $this->exceptionMessages[] = $this->name.' accepts only actual numbers as arguments, not boolean';

            return false;
        }

        if (!is_int($filter[0]) or $filter[0] < 0) {
            $this->exceptionMessages[] = $this->name.' accepts only numbers (not numeric strings) greater than or equal to zero';

            return false;
        }

        return true;
    }
}