<?php

namespace FindingAPI\Core\ItemFilter;

class StartTimeTo extends AbstractFilter implements FilterInterface
{
    /**
     * @param array $filter
     * @return bool
     */
    public function validateFilter() : bool
    {
        if (!$this->genericValidation($this->filter, 1)) {
            return false;
        }

        $filter = $this->filter[0];

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