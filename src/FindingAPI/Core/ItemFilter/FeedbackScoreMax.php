<?php

namespace FindingAPI\Core\ItemFilter;

class FeedbackScoreMax extends AbstractFilter implements FilterInterface
{
    /**
     * @return bool
     */
    public function validateFilter() : bool
    {
        if (!$this->genericValidation($this->filter, 1)) {
            return false;
        }

        if (count($this->filter) !== 1) {
            $this->exceptionMessages[] = $this->name.' can only have one value in the argument array';

            return false;
        }

        if (is_bool($this->filter[0])) {
            $this->exceptionMessages[] = $this->name.' accepts only actual numbers as arguments, not boolean';

            return false;
        }

        if (!is_int($this->filter[0]) or $this->filter[0] < 0) {
            $this->exceptionMessages[] = $this->name.' accepts only numbers (not numeric strings) greater than or equal to zero';

            return false;
        }

        return true;
    }
}