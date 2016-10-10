<?php

namespace FindingAPI\Core\ItemFilter;

use FindingAPI\Core\Information\SortOrder as InformationSortOrder;

class SortOrder extends AbstractFilter implements FilterInterface
{
    /**
     * @param array $filter
     * @return bool
     */
    public function validateFilter() : bool
    {
        if (!empty($this->filter)) {
            if (!$this->genericValidation($this->filter, 1)) {
                return false;
            }

            $filter = $this->filter[0];

            if (!InformationSortOrder::instance()->has($filter)) {
                $this->exceptionMessages[] = 'Invalid value for sortOrder. Please, refer to http://developer.ebay.com/devzone/finding/CallRef/extra/fndItmsByKywrds.Rqst.srtOrdr.html';

                return false;
            }
        }

        return true;
    }
}