<?php

namespace FindingAPI\Core\ResponseParser\ResponseItem\Child\Item;

use FindingAPI\Core\ResponseParser\ResponseItem\AbstractItemIterator;
use FindingAPI\Core\ResponseParser\ResponseItem\Child\Item\{
    Attribute, Condition, DiscountPriceInfo, ShippingInfo, ListingInfo, SellingStatus, PrimaryCategory
};

class Item extends AbstractItemIterator
{
    /**
     * @var array $distance
     */
    private $distance;
    /**
     * @var DiscountPriceInfo $discountPriceInfo
     */
    private $discountPriceInfo;
    /**
     * @var string $compatibility
     */
    private $compatibility;
    /**
     * @var string $charityId
     */
    private $charityId;
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

    public function getDistance($default = null)
    {
        if ($this->distance === null) {
            if (!empty($this->simpleXml->distance)) {
                $this->setDistance((string) $this->simpleXml->distance['unit'], (float) $this->simpleXml->distance);
            }
        }

        if ($this->distance === null and $default !== null) {
            return $default;
        }

        return $this->distance;
    }
    /**
     * @param $default
     * @return PrimaryCategory
     */
    public function getPrimaryCategory($default = null) : PrimaryCategory
    {
        if (!$this->primaryCategory instanceof PrimaryCategory) {
            if (!empty($this->simpleXml->primaryCategory)) {
                $this->setPrimaryCategory(new PrimaryCategory($this->simpleXml->primaryCategory));
            }
        }

        if (!$this->primaryCategory instanceof  PrimaryCategory and $default !== null) {
            return $default;
        }


        return $this->primaryCategory;
    }
    /**
     * @param $default
     * @return ShippingInfo
     */
    public function getShippingInfo($default = null) : ShippingInfo
    {
        if (!$this->shippingInfo instanceof ShippingInfo) {
            if (!empty($this->simpleXml->shippingInfo)) {
                $this->setShippingInfo(new ShippingInfo($this->simpleXml->shippingInfo));
            }
        }

        if (!$this->shippingInfo instanceof ShippingInfo and $default !== null) {
            return $default;
        }

        return $this->shippingInfo;
    }

    /**
     * @param null $default
     * @return \FindingAPI\Core\ResponseParser\ResponseItem\Child\Item\SellingStatus
     */
    public function getSellingStatus($default = null) : SellingStatus
    {
        if ($this->sellingStatus === null) {
            if (!empty($this->simpleXml->sellingStatus)) {
                $this->setSellingStatus(new SellingStatus($this->simpleXml->sellingStatus));
            }
        }

        if ($this->sellingStatus === null and $default !== null) {
            return $default;
        }

        return $this->sellingStatus;
    }
    /**
     * @param mixed $default
     * @return ListingInfo
     */
    public function getListingInfo($default = null) : ListingInfo
    {
        if ($this->listingInfo === null) {
            if (!empty($this->simpleXml->listingInfo)) {
                $this->setListingInfo(new ListingInfo($this->simpleXml->listingInfo));
            }
        }

        if ($this->listingInfo === null and $default !== null) {
            return $default;
        }

        return $this->listingInfo;
    }

    /**
     * @param mixed $default
     * @return \FindingAPI\Core\ResponseParser\ResponseItem\Child\Item\Condition|null
     */
    public function getCondition($default = null)
    {
        if ($this->condition === null) {
            if (!empty($this->simpleXml->condition)) {
                $this->setCondition(new Condition($this->simpleXml->condition));
            }
        }

        if ($this->condition === null and $default !== null) {
            return $default;
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

        if ($this->galleryUrl === null and $default !== null) {
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

        if ($this->viewItemUrl === null and $default !== null) {
            return $default;
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
        
        if ($this->autoPay === null and $default !== null) {
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

        if ($this->postalCode === null and $default !== null) {
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

        if ($this->location === null and $default !== null) {
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

        if ($this->country === null and $default !== null) {
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

        if ($this->returnsAccepted === null and $default !== null) {
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

        if ($this->isMultiVariationListing === null and $default !== null) {
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

        if ($this->topRatedListing === null and $default !== null) {
            return $default;
        }

        return $this->topRatedListing;
    }
    /**
     * @param null $default
     * @return Attribute[]|null
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

        if ($this->attributes === null and $default !== null) {
            return $default;
        }

        return $this->attributes;
    }
    /**
     * @param null $default
     * @return null
     */
    public function getCharityId($default = null) 
    {
        if ($this->charityId === null) {
            if (!empty($this->simpleXml->charityId)) {
                $this->setCharityId((string) $this->simpleXml->charityId);
            }
        }

        if ($this->charityId === null and $default !== null) {
            return $default;
        }

        return $this->charityId;
    }
    /**
     * @param null $default
     * @return null|string
     */
    public function getCompatibility($default = null)
    {
        if ($this->compatibility === null) {
            if (!empty($this->simpleXml->compatibility)) {
                $this->setCompatibility((string) $this->simpleXml->compatibility);
            }
        }

        if ($this->compatibility === null and $default !== null) {
            return $default;
        }

        return $this->compatibility;
    }
    /**
     * @param null $default
     * @return DiscountPriceInfo|null
     */
    public function getDiscountPriceInfo($default = null)
    {
        if (!$this->discountPriceInfo instanceof DiscountPriceInfo) {
            //var_dump($this->simpleXml->discountPriceInfo->originalRetailPrice);
            if (!empty($this->simpleXml->discountPriceInfo)) {
                $this->setDiscountPriceInfo(new DiscountPriceInfo($this->simpleXml->discountPriceInfo));
            }
        }

        if (!$this->discountPriceInfo instanceof DiscountPriceInfo and $default !== null) {
            return $default;
        }

        return $this->discountPriceInfo;
    }
    
    private function setDiscountPriceInfo(DiscountPriceInfo $discountPriceInfo) : Item 
    {
        $this->discountPriceInfo = $discountPriceInfo;

        return $this;
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

    private function setCharityId(string $charityId) : Item
    {
        $this->charityId = $charityId;

        return $this;
    }

    private function setCompatibility(string $compatibility) : Item
    {
        $this->compatibility = $compatibility;

        return $this;
    }

    private function setDistance(string $unit, float $distance) : Item
    {
        $this->distance = array(
            'unit' => $unit,
            'distance' => $distance,
        );

        return $this;
    }
}