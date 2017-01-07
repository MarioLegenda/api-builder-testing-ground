<?php

namespace FindingAPI\Core\Information;

class ListingTypeInformation
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
     * @var ListingTypeInformation $instance
     */
    private static $instance;
    /**
     * @return ListingTypeInformation
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
     * @return ListingTypeInformation
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