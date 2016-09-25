<?php

namespace FindingAPI\Core\ItemFilter;

class SortOrder extends AbstractConstraint implements FilterInterface
{
    const BEST_MATCH = 'BestMatch';
    const BID_COUNT_FEWEST = 'BidCountFewest';
    const BID_COUNT_MOST = 'BidCountMost';
    const COUNTRY_ASCENDING = 'CountryAscending';
    const COUNTRY_DESCENDING = 'CountryDescending';
    const CURRENT_PRICE_HIGHEST = 'CurrentPriceHighest';
    const DISTANCE_NEAREST = 'DistanceNearest';
    const END_TIME_SOONEST = 'EndTimeSoonest';
    const PRICE_PLUS_SHIPPING_HIGHEST = 'PricePlusShippingHighest';
    const PRICE_PLUS_SHIPPING_LOWEST = 'PricePlusShippingLowest';
    const START_TIME_NEWEST = 'StartTimeNewest';
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