<?php

namespace FindingAPI\Core\ResponseParser\ResponseItem\Child;

use FindingAPI\Core\ResponseParser\ResponseItem\AbstractItem;
use FindingAPI\Core\ResponseParser\ResponseItem\AbstractItemIterator;

class Item extends AbstractItemIterator
{
    /**
     * @var ListingInfo $listingInfo
     */
    private $listingInfo;
    /**
     * @var SellingStatus $sellingStatus
     */
    private $sellingStatus;
    /**
     * @var $shippingInfo
     */
    private $shippingInfo;
    /**
     * @var string $country
     */
    private $country;
    /**
     * @var string $location
     */
    private $location;
    /**
     * @var int $postalCode
     */
    private $postalCode;
    /**
     * @var bool $autoPay
     */
    private $autoPay;
    /**
     * @var string $paymentMethod
     */
    private $paymentMethod;
    /**
     * @var array $productId
     */
    private $productId;
    /**
     * @var string $viewItemUrl
     */
    private $viewItemUrl;
    /**
     * @var string $galleryUrl
     */
    private $galleryUrl;
    /**
     * @var PrimaryCategory $primaryCategory
     */
    private $primaryCategory;
    /**
     * @var string $globalId
     */
    private $globalId;
    /**
     * @var string $title
     */
    private $title;
    /**
     * @var string $itemId
     */
    private $itemId;



    /**
     * @return string
     */
    public function getItemId()
    {
        if ($this->itemId === null) {
            $this->setItemId((string)$this->simpleXml->itemId);
        }

        return $this->itemId;
    }

    /**
     * @return string
     */
    public function getTitle() : string
    {
        if ($this->title === null) {
            $this->setTitle((string)$this->simpleXml->{'title'});
        }

        return $this->title;
    }

    /**
     * @return string
     */
    public function getGlobalId() : string
    {
        if ($this->globalId === null) {
            $this->setGlobalId((string)$this->simpleXml->globalId);
        }

        return $this->globalId;
    }
    /**
     * @return PrimaryCategory
     */
    public function getPrimaryCategory() : PrimaryCategory
    {
        if (!$this->primaryCategory instanceof PrimaryCategory) {
            $this->setPrimaryCategory(new PrimaryCategory($this->simpleXml->primaryCategory));
        }

        return $this->primaryCategory;
    }
    /**
     * @return ShippingInfo
     */
    public function getShippingInfo() : ShippingInfo
    {
        if (!$this->shippingInfo instanceof ShippingInfo) {
            $this->setShippingInfo(new ShippingInfo($this->simpleXml->shippingInfo));
        }

        return $this->shippingInfo;
    }

    public function getSellingStatus() : SellingStatus
    {
        if ($this->sellingStatus === null) {
            $this->setSellingStatus(new SellingStatus($this->simpleXml->sellingStatus));
        }

        return $this->sellingStatus;
    }
    /**
     * @return ListingInfo
     */
    public function getListingInfo() : ListingInfo
    {
        if ($this->listingInfo === null) {
            $this->setListingInfo(new ListingInfo($this->simpleXml->listingInfo));
        }

        return $this->listingInfo;
    }

    /**
     * @return string
     */
    public function getGalleryUrl() : string
    {
        if ($this->galleryUrl === null) {
            $this->setGalleryUrl((string)$this->simpleXml->galleryURL);
        }

        return $this->galleryUrl;
    }

    /**
     * @return string
     */
    public function getViewItemUrl() : string
    {
        if ($this->viewItemUrl === null) {
            $this->setViewItemUrl((string)$this->simpleXml->viewItemURL);
        }

        return $this->viewItemUrl;
    }
    /**
     * @return array
     */
    public function getProductId() : array
    {
        if ($this->productId === null) {
            $this->setProductId((string) $this->simpleXml->productId['type'], (int) $this->simpleXml->productId);
        }

        return $this->productId;
    }
    /**
     * @return string
     */
    public function getPaymentMethod() : string
    {
        if ($this->paymentMethod === null) {
            $this->setPaymentMethod((string) $this->simpleXml->paymentMethod);
        }

        return $this->paymentMethod;
    }
    /**
     * @return bool|null
     */
    public function getAutoPay()
    {
        if ($this->autoPay === null) {
            $this->setAutoPay((bool) $this->simpleXml->autoPay);
        }

        return $this->autoPay;
    }

    /**
     * @return int|null
     */
    public function getPostalCode() 
    {
        if ($this->postalCode === null) {
            $this->setPostalCode((int) $this->simpleXml->postalCode);
        }
        
        return $this->postalCode;
    }
    /**
     * @return string
     */
    public function getLocation() : string
    {
        if ($this->location === null) {
            $this->setLocation((string) $this->simpleXml->location);
        }

        return $this->location;
    }
    /**
     * @return string
     */
    public function getCountry() : string
    {
        if ($this->country === null) {
            $this->setCountry((string) $this->simpleXml->country);
        }

        return $this->country;
    }

    private function setSellingStatus(SellingStatus $sellingStatus) : Item
    {
        $this->sellingStatus = $sellingStatus;

        return $this;
    }

    private function setLocation(string $location) : Item
    {
        $this->location = $location;

        return $this;
    }

    private function setCountry(string $country) : Item
    {
        $this->country = $country;

        return $this;
    }

    private function setPostalCode(int $postalCode) : Item
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    private function setPrimaryCategory(PrimaryCategory $primaryCategory) : Item
    {
        $this->primaryCategory = $primaryCategory;

        return $this;
    }

    private function setAutoPay(bool $autoPay) : Item
    {
        $this->autoPay = $autoPay;

        return $this;
    }

    private function setItemId(string $itemId) : Item
    {
        $this->itemId = $itemId;

        return $this;
    }

    private function setTitle(string $title) : Item
    {
        $this->title = $title;

        return $this;
    }

    private function setGlobalId(string $globalId) : Item
    {
        $this->globalId = $globalId;

        return $this;
    }

    private function setProductId(string $type, int $productId) : Item
    {
        $this->productId = array(
            'type' => $type,
            'productId' => $productId,
        );

        return $this;
    }

    private function setPaymentMethod(string $paymentMethod) : Item
    {
        $this->paymentMethod = $paymentMethod;

        return $this;
    }

    private function setViewItemUrl(string $url) : Item
    {
        $this->viewItemUrl = $url;

        return $this;
    }

    private function setGalleryUrl(string $galleryUrl) : Item
    {
        $this->galleryUrl = $galleryUrl;

        return $this;
    }

    private function setShippingInfo(ShippingInfo $shippingInfo) : Item
    {
        $this->shippingInfo = $shippingInfo;

        return $this;
    }
    
    private function setListingInfo(ListingInfo $listingInfo) : Item
    {
        $this->listingInfo = $listingInfo;

        return $this;
    }
}