<?php

namespace FindingAPI\Core\ItemFilter;

use FindingAPI\Core\Information\GlobalId;

class ListedIn extends AbstractFilter implements FilterInterface
{
    /**
     * @return bool
     */
    public function validateFilter() : bool
    {
        if (!$this->genericValidation($this->filter, 1)) {
            return false;
        }

        $filter = $this->filter[0];

        if (!GlobalId::instance()->has($filter)) {
            $this->exceptionMessages[] = $this->name.' has to have a valid global id. Please, refer to http://developer.ebay.com/devzone/finding/callref/Enums/GlobalIdList.html or use FindingAPI\Core\ItemFilter\GlobalId object';

            return false;
        }

        return true;
    }
}