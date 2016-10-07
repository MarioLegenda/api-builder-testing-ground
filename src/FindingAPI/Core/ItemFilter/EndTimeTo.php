<?php

namespace FindingAPI\Core\ItemFilter;

use FindingAPI\Core\Exception\ItemFilterException;

class EndTimeTo extends AbstractConstraint implements FilterInterface
{
    /**
     * @throws ItemFilterException
     */
    public function validateFilter(array $filters) : bool
    {
        if (!$this->genericValidation($filters, 1)) {
            return false;
        }

        $filter = $filters[0];

        if (!$filter instanceof \DateTime) {
            $this->exceptionMessages[] = 'Invalid value supplied for '.$this->name.' Value has to be a DateTime instance in the future';

            return false;
        }

        $currentDateTime = new \DateTime();

        $filter->setTimezone(new \DateTimeZone('UTC'));
        $currentDateTime->setTimezone(new \DateTimeZone('UTC'));

        if ($filter->getTimestamp() <= $currentDateTime->getTimestamp()) {
            $this->exceptionMessages[] = 'You have to specify a date in the future for '.$this->name.' item filter';

            return false;
        }

        return true;
    }
}