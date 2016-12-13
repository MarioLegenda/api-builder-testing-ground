<?php

namespace FindingAPI\Core\Information;

class SortOrder
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
     * @var array $sortOrders
     */
    private $sortOrders = array(
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
    /**
     * @var GlobalId $instance
     */
    private static $instance;
    /**
     * @return GlobalId
     */
    public static function instance()
    {
        self::$instance = (self::$instance instanceof self) ? self::$instance : new self();

        return self::$instance;
    }
    /**
     * @param string $id
     * @return mixed
     */
    public function has(string $sort) : bool
    {
        return in_array($sort, $this->sortOrders) !== false;
    }
    /**
     * @param string $name
     * @param array $values
     * @return GlobalId
     */
    public function add(string $sort)
    {
        if ($this->has($sort)) {
            return null;
        }

        $this->sortOrders[] = $sort;

        return $this;
    }
    /**
     * @return array
     */
    public function getAll()
    {
        return $this->sortOrders;
    }
}