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
    public function addItemFilter(string $name, $anonymousClass)
    {
        if (!$anonymousClass instanceof FilterInterface and !$anonymousClass instanceof AbstractConstraint) {
            throw new ItemFilterException('When adding new item filter, anonymous class has to extend FindingAPI\Core\ItemFilter\AbstractConstraint and implement FindingAPI\Core\ItemFilter\FilterInterface');
        }

        if ($this->hasItemFilter($name)) {
            throw new ItemFilterException('Item filter '.$name.' already exists. If you whish to update an item filter, use ItemFilterStorage::updateItemFilter()');
        }

        $this->itemFilters[$name]['object'] = $anonymousClass;
        $this->itemFilters[$name]['value'] = null;
    }
    /**
     * @param string $name
     * @return bool
     */
    public function removeItemFilter(string $name) : bool
    {
        if ($this->hasItemFilter($name)) {
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