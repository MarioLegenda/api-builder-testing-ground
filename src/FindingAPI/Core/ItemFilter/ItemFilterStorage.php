<?php

namespace FindingAPI\Core\ItemFilter;

use FindingAPI\Core\Exception\ItemFilterException;

class ItemFilterStorage implements \Countable, \IteratorAggregate
{
    /**
     * @var array $itemFilters
     */
    private $itemFilters = array();

    /**
     * ItemFilterStorage constructor.
     */
    public function __construct()
    {
        $this->itemFilters = array(
            'AuthorizedSellerOnly' => array (
                'object' => __NAMESPACE__.'\\AuthorizedSellerOnly',
                'value' => null,
            ),
            'AvailableTo' => array(
                'object' => __NAMESPACE__.'\\AvailableTo',
                'value' => null,
            ),
            'BestOfferOnly' => array(
                'object' => __NAMESPACE__.'\\BestOfferOnly',
                'value' => null,
            ),
            'CharityOnly' => array(
                'object' => __NAMESPACE__.'\\CharityOnly',
                'value' => null,
            ),
            'Condition' => array(
                'object' => __NAMESPACE__.'\\Condition',
                'value' => null,
            ),
            'Currency' => array(
                'object' => __NAMESPACE__.'\\Currency',
                'value' => null,
            ),
            'EndTimeFrom' => array(
                'object' => __NAMESPACE__.'\\EndTimeFrom',
                'value' => null,
            ),
            'EndTimeTo' => array(
                'object' => __NAMESPACE__.'\\EndTimeTo',
                'value' => null,
            ),
            'ExcludeAutoPay' => array(
                'object' => __NAMESPACE__.'\\ExcludeAutoPay',
                'value' => null,
            ),
            'ExcludeCategory' => array(
                'object' => __NAMESPACE__.'\\ExcludeCategory',
                'value' => null,
            ),
            'ExcludeSeller' => array(
                'object' => __NAMESPACE__.'\\ExcludeSeller',
                'value' => null,
            ),
            'ExpeditedShippingType' => array(
                'object' => __NAMESPACE__.'\\ExpeditedShippingType',
                'value' => null,
            ),
            'FeaturedOnly' => array(
                'object' => __NAMESPACE__.'\\FeaturedOnly',
                'value' => null,
            ),
            'FeedbackScoreMax' => array(
                'object' => __NAMESPACE__.'\\FeedbackScoreMax',
                'value' => null,
            ),
            'FeedbackScoreMin' => array(
                'object' => __NAMESPACE__.'\\FeedbackScoreMin',
                'value' => null,
            ),
            'FreeShippingOnly' => array(
                'object' => __NAMESPACE__.'\\FreeShippingOnly',
                'value' => null,
            ),
            'GetItFastOnly' => array(
                'object' => __NAMESPACE__.'\\GetItFastOnly',
                'value' => null,
            ),
            'HideDuplicateItems' => array(
                'object' => __NAMESPACE__.'\\HideDuplicateItems',
                'value' => null,
            ),
            'ListedIn' => array(
                'object' => __NAMESPACE__.'\\ListedIn',
                'value' => null,
            ),
            'ListingType' => array(
                'object' => __NAMESPACE__.'\\ListingType',
                'value' => null,
            ),
            'LocalPickupOnly' => array(
                'object' => __NAMESPACE__.'\\LocalPickupOnly',
                'value' => null,
            ),
            'LocalSearchOnly' => array(
                'object' => __NAMESPACE__.'\\LocalSearchOnly',
                'value' => null,
            ),
            'LocatedIn' => array(
                'object' => __NAMESPACE__.'\\LocatedIn',
                'value' => null,
            ),
            'LotsOnly' => array(
                'object' => __NAMESPACE__.'\\LotsOnly',
                'value' => null,
            ),
            'MaxBids' => array(
                'object' => __NAMESPACE__.'\\MaxBids',
                'value' => null,
            ),
            'MaxDistance' => array(
                'object' => __NAMESPACE__.'\\MaxDistance',
                'value' => null,
            ),
            'MaxHandlingTime' => array(
                'object' => __NAMESPACE__.'\\MaxHandlingTime',
                'value' => null,
            ),
            'SortOrder' => array(
                'object' => __NAMESPACE__.'\\SortOrder',
                'value' => null,
            ),
            'BuyerPostalCode' => array(
                'object' => __NAMESPACE__.'\\BuyerPostalCode',
                'value' => null,
            ),
            'PaginationInput' => array(
                'object' => __NAMESPACE__.'\\PaginationInput',
                'value' => null,
            ),
            'MaxPrice' => array(
                'object' => __NAMESPACE__.'\\MaxPrice',
                'value' => null,
            ),
            'MaxQuantity' => array(
                'object' => __NAMESPACE__.'\\MaxQuantity',
                'value' => null,
            ),
            'MinBids' => array(
                'object' => __NAMESPACE__.'\\MinBids',
                'value' => null,
            ),
            'MinPrice' => array(
                'object' => __NAMESPACE__.'\\MinPrice',
                'value' => null,
            ),
            'MinQuantity' => array(
                'object' => __NAMESPACE__.'\\MinQuantity',
                'value' => null,
            ),
            'ModTimeFrom' => array(
                'object' => __NAMESPACE__.'\\ModTimeFrom',
                'value' => null,
            ),
            'OutletSellerOnly' => array(
                'object' => __NAMESPACE__.'\\OutletSellerOnly',
                'value' => null,
            ),
            'PaymentMethod' => array(
                'object' => __NAMESPACE__.'\\PaymentMethod',
                'value' => null,
            ),
            'ReturnsAcceptedOnly' => array(
                'object' => __NAMESPACE__.'\\ReturnsAcceptedOnly',
                'value' => null,
            ),
            'Seller' => array(
                'object' => __NAMESPACE__.'\\Seller',
                'value' => null,
            ),
            'SellerBusinessType' => array(
                'object' => __NAMESPACE__.'\\SellerBusinessType',
                'value' => null,
            ),
            'SoldItemsOnly' => array(
                'object' => __NAMESPACE__.'\\SoldItemsOnly',
                'value' => null,
            ),
            'StartTimeFrom' => array(
                'object' => __NAMESPACE__.'\\StartTimeFrom',
                'value' => null,
            ),
            'StartTimeTo' => array(
                'object' => __NAMESPACE__.'\\StartTimeTo',
                'value' => null,
            ),
            'TopRatedSellerOnly' => array(
                'object' => __NAMESPACE__.'\\TopRatedSellerOnly',
                'value' => null,
            ),
            'WorldOfGoodOnly' => array(
                'object' => __NAMESPACE__.'\\WorldOfGoodOnly',
                'value' => null,
            ),
        );
    }
    /**
     * @param string $name
     * @return mixed|null
     */
    public function getItemFilter(string $name)
    {
        if (!$this->hasItemFilter($name)) {
            return null;
        }

        return $this->itemFilters[$name];
    }
    /**
     * @param string $name
     * @return bool
     */
    public function hasItemFilter(string $name) : bool
    {
        return array_key_exists($name, $this->itemFilters);
    }

    /**
     * @param string $name
     * @param $anonymousClass
     * @return string
     * @throws ItemFilterException
     */
    public function addItemFilter(string $name, $validator)
    {
        if ($this->hasItemFilter($name)) {
            throw new ItemFilterException('Item filter '.$name.' already exists. If you whish to update an item filter, use ItemFilterStorage::updateItemFilter()');
        }

        $this->itemFilters[$name]['object'] = $validator;
        $this->itemFilters[$name]['value'] = null;
    }
    /**
     * @param string $name
     * @return bool
     */
    public function removeItemFilter(string $name) : bool
    {
        if (!$this->hasItemFilter($name)) {
            return false;
        }

        unset($this->itemFilters[$name]);

        return true;
    }
    /**
     * @param string $name
     * @param $anonymousClass
     * @return bool
     */
    public function updateItemFilter(string $name, $anonymousClass) : bool
    {
        if ($this->hasItemFilter($name)) {
            $this->itemFilters[$name]['object'] = $anonymousClass;

            return true;
        }

        return false;
    }
    /**
     * @param string $name
     * @param array $value
     * @throws ItemFilterException
     */
    public function updateItemFilterValue(string $name, array $value)
    {
        if (!$this->hasItemFilter($name)) {
            throw new ItemFilterException('Item filter '.$name.' does not exist');
        }

        $this->itemFilters[$name]['value'] = $value;
    }

    /**
     * @return array
     */
    public function filterAddedFilter() : array
    {
        return array_filter($this->itemFilters, function ($value) {
            return $value['value'] !== null;
        });
    }
    /**
     * @return int
     */
    public function count() : int
    {
        return count($this->itemFilters);
    }
    /**
     * @return \ArrayIterator
     */
    public function getIterator() : \ArrayIterator
    {
        return new \ArrayIterator($this->itemFilters);
    }
}