<?php

namespace FindingAPI\Core\ItemFilter;

use FindingAPI\Core\Information\GlobalId;

class ListedIn extends AbstractConstraint implements FilterInterface
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

        if (!GlobalId::instance()->has($filter)) {
            $this->exceptionMessages[] = $this->name.' has to have a valid global id. Please, refer to http://developer.ebay.com/devzone/finding/callref/Enums/GlobalIdList.html or use FindingAPI\Core\ItemFilter\GlobalId object';

            return false;
        }

        return true;
    }
}