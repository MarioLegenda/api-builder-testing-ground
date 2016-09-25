<?php

namespace FindingAPI\Core\ItemFilter;

class SortOrder extends AbstractConstraint implements FilterInterface
{
    /**
     * @param array $filter
     * @return bool
     */
    public function validateFilter(array $filter) : bool
    {
        if (!empty($filter)) {
            $validValue = array(
                'BestMatch',
                'BidCountFewest',
                'BidCountMost',
                'CountryAscending',
                'CountryDescending',
                'CurrentPriceHighest',
                'DistanceNearest',
                'EndTimeSoonest',
                'PricePlusShippingHighest',
                'PricePlusShippingLowest',
                'StartTimeNewest',
             );

            if (!$this->genericValidation($filter, 1)) {
                return false;
            }

            $filter = $filter[0];

            if (in_array($filter, $validValue) === false) {
                $this->exceptionMessages[] = 'Invalid value for sortOrder. Please, refer to http://developer.ebay.com/devzone/finding/CallRef/extra/fndItmsByKywrds.Rqst.srtOrdr.html';

                return false;
            }
        }

        return true;
    }
}