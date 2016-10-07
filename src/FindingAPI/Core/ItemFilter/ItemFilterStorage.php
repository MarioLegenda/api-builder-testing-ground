<?php

namespace FindingAPI\Core\ItemFilter;

use FindingAPI\Core\Exception\ItemFilterException;

class ItemFilterStorage implements \Countable, \IteratorAggregate
{
    /**
     * @var array $itemFilters
     */
    private $itemFilters = array(
        'AuthorizedSellerOnly' => array (
            'object' => __NAMESPACE__.'\\AuthorizedSellerOnly',
            'value' => null,
            'multiple_values' => false,
            'date_time' => false,
        ),
        'AvailableTo' => array(
            'object' => __NAMESPACE__.'\\AvailableTo',
            'value' => null,
            'multiple_values' => false,
            'date_time' => false,
        ),
        'BestOfferOnly' => array(
            'object' => __NAMESPACE__.'\\BestOfferOnly',
            'value' => null,
            'multiple_values' => false,
            'date_time' => false,
        ),
        'CharityOnly' => array(
            'object' => __NAMESPACE__.'\\CharityOnly',
            'value' => null,
            'multiple_values' => false,
            'date_time' => false,
        ),
        'Condition' => array(
            'object' => __NAMESPACE__.'\\Condition',
            'value' => null,
            'multiple_values' => true,
            'date_time' => false,
        ),
        'Currency' => array(
            'object' => __NAMESPACE__.'\\Currency',
            'value' => null,
            'multiple_values' => false,
            'date_time' => false,
        ),
        'EndTimeFrom' => array(
            'object' => __NAMESPACE__.'\\EndTimeFrom',
            'value' => null,
            'multiple_values' => false,
            'date_time' => true,
        ),
        'EndTimeTo' => array(
            'object' => __NAMESPACE__.'\\EndTimeTo',
            'value' => null,
            'multiple_values' => false,
            'date_time' => true,
        ),
        'ExcludeAutoPay' => array(
            'object' => __NAMESPACE__.'\\ExcludeAutoPay',
            'value' => null,
            'multiple_values' => false,
            'date_time' => false,
        ),
        'ExcludeCategory' => array(
            'object' => __NAMESPACE__.'\\ExcludeCategory',
            'value' => null,
            'multiple_values' => true,
            'date_time' => false,
        ),
        'ExcludeSeller' => array(
            'object' => __NAMESPACE__.'\\ExcludeSeller',
            'value' => null,
            'multiple_values' => true,
            'date_time' => false,
        ),
        'ExpeditedShippingType' => array(
            'object' => __NAMESPACE__.'\\ExpeditedShippingType',
            'value' => null,
            'multiple_values' => false,
            'date_time' => false,
        ),
        'FeaturedOnly' => array(
            'object' => __NAMESPACE__.'\\FeaturedOnly',
            'value' => null,
            'multiple_values' => false,
            'date_time' => false,
        ),
        'FeedbackScoreMax' => array(
            'object' => __NAMESPACE__.'\\FeedbackScoreMax',
            'value' => null,
            'multiple_values' => false,
            'date_time' => false,
        ),
        'FeedbackScoreMin' => array(
            'object' => __NAMESPACE__.'\\FeedbackScoreMin',
            'value' => null,
            'multiple_values' => false,
            'date_time' => false,
        ),
        'FreeShippingOnly' => array(
            'object' => __NAMESPACE__.'\\FreeShippingOnly',
            'value' => null,
            'multiple_values' => false,
            'date_time' => false,
        ),
        'GetItFastOnly' => array(
            'object' => __NAMESPACE__.'\\GetItFastOnly',
            'value' => null,
            'multiple_values' => false,
            'date_time' => false,
        ),
        'HideDuplicateItems' => array(
            'object' => __NAMESPACE__.'\\HideDuplicateItems',
            'value' => null,
            'multiple_values' => false,
            'date_time' => false,
        ),
        'ListedIn' => array(
            'object' => __NAMESPACE__.'\\ListedIn',
            'value' => null,
            'multiple_values' => false,
            'date_time' => false,
        ),
        'ListingType' => array(
            'object' => __NAMESPACE__.'\\ListingType',
            'value' => null,
            'multiple_values' => true,
            'date_time' => false,
        ),
        'LocalPickupOnly' => array(
            'object' => __NAMESPACE__.'\\LocalPickupOnly',
            'value' => null,
            'multiple_values' => false,
            'date_time' => false,
        ),
        'LocalSearchOnly' => array(
            'object' => __NAMESPACE__.'\\LocalSearchOnly',
            'value' => null,
            'multiple_values' => false,
            'date_time' => false,
        ),
        'LocatedIn' => array(
            'object' => __NAMESPACE__.'\\LocatedIn',
            'value' => null,
            'multiple_values' => true,
            'date_time' => false,
        ),
        'LotsOnly' => array(
            'object' => __NAMESPACE__.'\\LotsOnly',
            'value' => null,
            'multiple_values' => false,
            'date_time' => false,
        ),
        'MaxBids' => array(
            'object' => __NAMESPACE__.'\\MaxBids',
            'value' => null,
            'multiple_values' => false,
            'date_time' => false,
        ),
        'MaxDistance' => array(
            'object' => __NAMESPACE__.'\\MaxDistance',
            'value' => null,
            'multiple_values' => false,
            'date_time' => false,
        ),
        'MaxHandlingTime' => array(
            'object' => __NAMESPACE__.'\\MaxHandlingTime',
            'value' => null,
            'multiple_values' => false,
            'date_time' => false,
        ),
        'SortOrder' => array(
            'object' => __NAMESPACE__.'\\SortOrder',
            'value' => null,
            'multiple_values' => false,
            'date_time' => false,
        ),
        'BuyerPostalCode' => array(
            'object' => __NAMESPACE__.'\\BuyerPostalCode',
            'value' => null,
            'multiple_values' => false,
            'date_time' => false,
        ),
        'PaginationInput' => array(
            'object' => __NAMESPACE__.'\\PaginationInput',
            'value' => null,
            'multiple_values' => false,
            'date_time' => false,
        ),
        'MaxPrice' => array(
            'object' => __NAMESPACE__.'\\MaxPrice',
            'value' => null,
            'multiple_values' => false,
            'date_time' => false,
        ),
        'MaxQuantity' => array(
            'object' => __NAMESPACE__.'\\MaxQuantity',
            'value' => null,
            'multiple_values' => false,
            'date_time' => false,
        ),
        'MinBids' => array(
            'object' => __NAMESPACE__.'\\MinBids',
            'value' => null,
            'multiple_values' => false,
            'date_time' => false,
        ),
        'MinPrice' => array(
            'object' => __NAMESPACE__.'\\MinPrice',
            'value' => null,
            'multiple_values' => false,
            'date_time' => false,
        ),
        'MinQuantity' => array(
            'object' => __NAMESPACE__.'\\MinQuantity',
            'value' => null,
            'multiple_values' => false,
            'date_time' => false,
        ),
        'ModTimeFrom' => array(
            'object' => __NAMESPACE__.'\\ModTimeFrom',
            'value' => null,
            'multiple_values' => false,
            'date_time' => true,
        ),
        'OutletSellerOnly' => array(
            'object' => __NAMESPACE__.'\\OutletSellerOnly',
            'value' => null,
            'multiple_values' => false,
            'date_time' => false,
        ),
        'PaymentMethod' => array(
            'object' => __NAMESPACE__.'\\PaymentMethod',
            'value' => null,
            'multiple_values' => false,
            'date_time' => false,
        ),
        'ReturnsAcceptedOnly' => array(
            'object' => __NAMESPACE__.'\\ReturnsAcceptedOnly',
            'value' => null,
            'multiple_values' => false,
            'date_time' => false,
        ),
        'Seller' => array(
            'object' => __NAMESPACE__.'\\Seller',
            'value' => null,
            'multiple_values' => true,
            'date_time' => false,
        ),
        'SellerBusinessType' => array(
            'object' => __NAMESPACE__.'\\SellerBusinessType',
            'value' => null,
            'multiple_values' => true,
            'date_time' => false,
        ),
        'SoldItemsOnly' => array(
            'object' => __NAMESPACE__.'\\SoldItemsOnly',
            'value' => null,
            'multiple_values' => false,
            'date_time' => false,
        ),
        'StartTimeFrom' => array(
            'object' => __NAMESPACE__.'\\StartTimeFrom',
            'value' => null,
            'multiple_values' => false,
            'date_time' => true,
        ),
        'StartTimeTo' => array(
            'object' => __NAMESPACE__.'\\StartTimeTo',
            'value' => null,
            'multiple_values' => false,
            'date_time' => true,
        ),
        'TopRatedSellerOnly' => array(
            'object' => __NAMESPACE__.'\\TopRatedSellerOnly',
            'value' => null,
            'multiple_values' => false,
            'date_time' => false,
        ),
        'WorldOfGoodOnly' => array(
            'object' => __NAMESPACE__.'\\WorldOfGoodOnly',
            'value' => null,
            'multiple_values' => false,
            'date_time' => false,
        ),
    );

    /**
     * ItemFilterStorage constructor.
     */
    public function __construct()
    {
        foreach ($this->itemFilters as $itemFilterName => $itemFilter) {
            $this->validateItemFilter(array(
                $itemFilterName => $itemFilter,
            ));
        }
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
     * @param array $configuration
     * @return string
     * @throws ItemFilterException
     */
    public function addItemFilter(array $configuration)
    {
        $this->validateItemFilter($configuration);

        $itemFilterName = array_keys($configuration)[0];

        $this->itemFilters[$itemFilterName] = $configuration[$itemFilterName];
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
    public function updateItemFilterValidator(string $name, $validator) : bool
    {
        if ($this->hasItemFilter($name)) {
            $this->itemFilters[$name]['object'] = $validator;

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
     * @param string $name
     * @return FilterInterface
     * @throws ItemFilterException
     */
    public function getItemFilterInstance(string $name) : FilterInterface
    {
        if (!$this->hasItemFilter($name)) {
            throw new ItemFilterException('Item filter '.$name.' does not exist');
        }

        if (!$this->itemFilters[$name]['object'] instanceof FilterInterface) {
            $itemFilterClass = $this->itemFilters[$name]['object'];
            $itemFilterValue = $this->itemFilters[$name]['value'];

            $configuration = array(
                'multiple_values' => $this->itemFilters[$name]['multiple_values'],
                'date_time' => $this->itemFilters[$name]['date_time'],
            );

            $this->itemFilters[$name]['object'] = new $itemFilterClass($name, $itemFilterValue, $configuration);

            return $this->itemFilters[$name]['object'];
        }

        return $this->itemFilters[$name]['object'];
    }

    /**
     * @param mixed $toExclude
     * @return array
     */
    public function filterAddedFilter($toExclude = array()) : array
    {
        $filtered = array();

        foreach ($this->itemFilters as $name => $itemFilter) {
            if (in_array($name, $toExclude) === false) {
                if ($itemFilter['value'] !== null) {
                    $filtered[$name] = $itemFilter;
                }
            }
        }

        return $filtered;
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
        return new \ArrayIterator();
    }

    private function validateItemFilter(array $configuration)
    {
        $allowedKeys = array('object', 'value', 'multiple_values', 'date_time');

        $exceptionMessage = 'When adding new item filters, only one key, as the name of the new item filter, and an array of that key with keys '.implode(', ', $allowedKeys);

        if (count($configuration) > 1) {
            throw new ItemFilterException($exceptionMessage);
        }

        $itemFilterName = array_keys($configuration);

        if (!is_string($itemFilterName[0])) {
            throw new ItemFilterException($exceptionMessage);
        }

        $configKeys = array_keys($configuration[$itemFilterName[0]]);

        if (!empty(array_diff($allowedKeys, $configKeys))) {
            throw new ItemFilterException($exceptionMessage.' for item filter '.$itemFilterName[0]);
        }

    }
}