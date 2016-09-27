<?php

namespace FindingAPI\Core\ItemFilter;

use FindingAPI\Core\Information\SortOrder as InformationSortOrder;

class SortOrder extends AbstractConstraint implements FilterInterface
{
    /**
     * @param array $filter
     * @return bool
     */
    public function validateFilter(array $filter) : bool
    {
        if (!empty($filter)) {
            if (!$this->genericValidation($filter, 1)) {
                return false;
            }

            $filter = $filter[0];

            if (!InformationSortOrder::instance()->has($filter)) {
                $this->exceptionMessages[] = 'Invalid value for sortOrder. Please, refer to http://developer.ebay.com/devzone/finding/CallRef/extra/fndItmsByKywrds.Rqst.srtOrdr.html';

                return false;
            }
        }

        return true;
    }
}