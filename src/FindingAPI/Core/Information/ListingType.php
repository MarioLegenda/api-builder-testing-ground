<?php

namespace FindingAPI\Core\Information;

class ListingType
{
    const ALL = 'All';
    const AUCTION = 'Auction';
    const AUCTION_WITH_BIN = 'AuctionWithBIN';
    const CLASSIFIED = 'Classified';
    const FIXED_PRICE = 'FixedPrice';
    const STORE_INVENTORY = 'StoreInventory';
    /**
     * @var array $listingTypes
     */
    private $listingTypes = array(
        'All',
        'Auction',
        'AuctionWithBIN',
        'Classified',
        'FixedPrice',
        'StoreInventory'
    );
    /**
     * @var ListingType $instance
     */
    private static $instance;
    /**
     * @return ListingType
     */
    public static function instance()
    {
        self::$instance = (self::$instance instanceof self) ? self::$instance : new self();

        return self::$instance;
    }
    /**
     * @param string $method
     * @return mixed
     */
    public function has(string $method) : bool
    {
        return in_array($method, $this->listingTypes) !== false;
    }
    /**
     * @param string $method
     * @return ListingType
     */
    public function add(string $method)
    {
        if ($this->has($method)) {
            return null;
        }

        $this->listingTypes[] = $method;

        return $this;
    }
    /**
     * @return array
     */
    public function getAll()
    {
        return $this->listingTypes;
    }
}