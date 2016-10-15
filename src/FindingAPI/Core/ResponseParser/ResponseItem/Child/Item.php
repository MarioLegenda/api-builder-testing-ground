<?php

namespace FindingAPI\Core\ResponseParser\ResponseItem\Child;

use FindingAPI\Core\ResponseParser\ResponseItem\AbstractItemIterator;
use FindingAPI\Core\ResponseParser\ResponseItem\Child\Item\{
    Attribute, Condition, ShippingInfo, ListingInfo, SellingStatus, PrimaryCategory
};

class Item extends AbstractItemIterator
{
    /**
     * @var Attribute[] $attributes
     */
    private $attributes;
    /**
     * @var Condition $condition
     */
    private $condition;
    /**
     * @var bool $topRatedListing
     */
    private $topRatedListing;
    /**
     * @var bool $isMultiVariationListing
     */
    private $isMultiVariationListing;
    /**
     * @var bool $returnsAccepted
     */
    private $returnsAccepted;
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
     * @param mixed $default
     * @return string
     */
    public function getTitle($default = null) : string
    {
        if ($this->title === null) {
            $this->setTitle((string)$this->simpleXml->{'title'});
        }

        if ($default !== null) {
            return $default;
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

    public function getCondition()
    {
        if ($this->condition === null) {
            if (!empty($this->simpleXml->condition)) {
                $this->setCondition(new Condition($this->simpleXml->condition));
            }
        }

        return $this->condition;
    }

    /**
     * @param mixed $default
     * @return string
     */
    public function getGalleryUrl($default = null) : string
    {
        if ($this->galleryUrl === null) {
            if (!empty($this->simpleXml->galleryURL)) {
                $this->setGalleryUrl((string) $this->simpleXml->galleryURL);
            }
        }

        if ($default !== null) {
            return $default;
        }

        return $this->galleryUrl;
    }

    /**
     * @param mixed $default
     * @return string
     */
    public function getViewItemUrl($default = null) : string
    {
        if ($this->viewItemUrl === null) {
            if ($this->simpleXml->viewItemURL) {
                $this->setViewItemUrl((string)$this->simpleXml->viewItemURL);
            }
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
     * @param mixed $default
     * @return bool|null
     */
    public function getAutoPay($default = null)
    {
        if ($this->autoPay === null) {
            if (!empty($this->simpleXml->autoPay)) {
                $this->setAutoPay((bool) $this->simpleXml->autoPay);
            }
        }
        
        if ($default !== null) {
            return $default;
        }

        return $this->autoPay;
    }

    /**
     * @param mixed $default
     * @return int|null
     */
    public function getPostalCode($default = null) 
    {
        if ($this->postalCode === null) {
            if (!empty($this->simpleXml->postalCode)) {
                $this->setPostalCode((int) $this->simpleXml->postalCode);
            }
        }

        if ($default !== null) {
            return $default;
        }

        return $this->postalCode;
    }
    /**
     * @param mixed $default
     * @return string
     */
    public function getLocation($default = null) : string
    {
        if ($this->location === null) {
            if (!empty($this->simpleXml->location)) {
                $this->setLocation((string) $this->simpleXml->location);
            }
        }

        if ($default !== null) {
            return $default;
        }

        return $this->location;
    }
    /**
     * @param $default
     * @return string
     */
    public function getCountry($default = null) : string
    {
        if ($this->country === null) {
            if (!empty($this->simpleXml->country)) {
                $this->setCountry((string) $this->simpleXml->country);
            }
        }

        if ($default !== null) {
            return $default;
        }

        return $this->country;
    }
    /**
     * @param null $default
     * @return bool|null
     */
    public function getReturnsAccepted($default = null) 
    {
        if ($this->returnsAccepted === null) {
            if (!empty($this->simpleXml->returnsAccepted)) {
                $this->setReturnsAccepted((bool) $this->simpleXml->returnsAccepted);
            }
        }

        if ($default !== null) {
            return $default;
        }

        return $this->returnsAccepted;
    }
    /**
     * @param null $default
     * @return bool|null
     */
    public function getIsMultiVariationListing($default = null) 
    {
        if ($this->isMultiVariationListing === null) {
            if (!empty($this->simpleXml->isMultiVariationListing)) {
                $this->setIsMultiVariationListing((bool) $this->simpleXml->isMultiVariationListing);
            }
        }

        if ($default !== null) {
            return $default;
        } 

        return $this->isMultiVariationListing;
    }
    /**
     * @param null $default
     * @return bool|null
     */
    public function getTopRatedListing($default = null) 
    {
        if ($this->topRatedListing === null) {
            if (!empty($this->simpleXml->topRatedListing)) {
                $this->setTopRatedListing((bool) $this->simpleXml->topRatedListing);
            }
        }

        if ($default !== null) {
            return $default;
        }

        return $this->topRatedListing;
    }
    /**
     * @param null $default
     * @return Item\Attribute[]|null
     */
    public function getAttributes($default = null)
    {
        if ($this->attributes === null) {
            if (!empty($this->simpleXml->attribute)) {
                foreach ($this->attribute as $attr) {
                    $this->setAttribute(new Attribute($attr));
                }
            }
        }

        if ($default !== null) {
            return $default;
        }

        return $this->attributes;
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

    private function setReturnsAccepted(bool $returnsAccepted) : Item
    {
        $this->returnsAccepted = $returnsAccepted;
        
        return $this;
    }

    private function setIsMultiVariationListing(bool $isMultiVariationListing) : Item
    {
        $this->isMultiVariationListing = $isMultiVariationListing;

        return $this;
    }

    private function setTopRatedListing(bool $topRatedListing) : Item
    {
        $this->topRatedListing = $topRatedListing;

        return $this;
    }

    private function setCondition(Condition $condition) : Item
    {
        $this->condition = $condition;

        return $this;
    }

    private function setAttribute(Attribute $attribute) : Item
    {
        $this->attributes[] = $attribute;

        return $this;
    }
}