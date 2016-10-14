<?php

namespace FindingAPI\Core\ResponseParser\ResponseItem\Child;

use FindingAPI\Core\ResponseParser\ResponseItem\AbstractItem;

class ListingInfo extends AbstractItem
{
    /**
     * @var bool $bestOfferEnabled
     */
    private $bestOfferEnabled;
    /**
     * @var bool $buyItNowAvailable
     */
    private $buyItNowAvailable;
    /**
     * @var array $buyItNowPrice
     */
    private $buyItNowPrice;
    /**
     * @var array $convertedBuyItNowPrice
     */
    private $convertedBuyItNowPrice;
    /**
     * @var \DateTime $endTime
     */
    private $endTime;
    /**
     * @var bool $gift
     */
    private $gift;
    /**
     * @var string $listingType
     */
    private $listingType;
    /**
     * @var \DateTime $startTime
     */
    private $startTime;
    /**
     * @return bool|null
     */
    public function getBestOfferEnabled()
    {
        if ($this->bestOfferEnabled === null) {
            if (!empty($this->simpleXml->bestOfferEnabled)) {
                $this->setBestOfferEnabled((bool) $this->simpleXml->bestOfferEnabled);
            }
        }

        return $this->bestOfferEnabled;
    }
    /**
     * @return bool|null
     */
    public function getBuyItNowAvailable()
    {
        if ($this->buyItNowAvailable === null) {
            if (!empty($this->simpleXml->buyItNowAvailable)) {
                $this->setBuyItNowAvailable((bool) $this->simpleXml->buyItNowAvailable);
            }
        }

        return $this->buyItNowAvailable;
    }
    /**
     * @return array|null
     */
    public function getBuyItNowPrice()
    {
        if ($this->buyItNowPrice === null) {
            if (!empty($this->simpleXml->buyItNowPrice)) {
                $this->setBuyItNowPrice((string) $this->simpleXml->buyItNowPrice['currencyId'], (float) $this->simpleXml->buyItNowPrice);
            }
        }

        return $this->buyItNowPrice;
    }
    /**
     * @return array|null
     */
    public function getConvertedBuyItNowPrice()
    {
        if ($this->convertedBuyItNowPrice === null) {
            if (!empty($this->simpleXml->convertedBuyItNowPrice)) {
                $this->setConvertedBuyItNowPrice((string) $this->simpleXml->convertedBuyItNowPrice['currencyId'], (float) $this->simpleXml->convertedBuyItNowPrice);
            }
        }

        return $this->convertedBuyItNowPrice;
    }
    /**
     * @return \DateTime|null
     */
    public function getEndTime()
    {
        if ($this->endTime === null) {
            if (!empty($this->simpleXml->endTime)) {
                $this->setEndTime((string) $this->simpleXml->endTime);
            }
        }

        return $this->endTime;
    }

    /**
     * @return bool|null
     */
    public function getGift()
    {
        if ($this->gift === null) {
            if (!empty($this->simpleXml->gift)) {
                $this->setGift((bool) $this->simpleXml->gift);
            }
        }

        return $this->gift;
    }
    /**
     * @return null|string
     */
    public function getListingType()
    {
        if ($this->listingType === null) {
            if (!empty($this->simpleXml->listingType)) {
                $this->setListingType((string) $this->simpleXml->listingType);
            }
        }

        return $this->listingType;
    }
    /**
     * @return \DateTime|null
     */
    public function getStartTime()
    {
        if ($this->startTime === null) {
            if (!empty($this->simpleXml->startTime)) {
                $this->setStartTime((string) $this->simpleXml->startTime);
            }
        }

        return $this->startTime;
    }

    private function setStartTime(string $startTime) : ListingInfo
    {
        $this->startTime = $startTime;

        return $this;
    }

    private function setListingType(string $listingType) : ListingInfo
    {
        $this->listingType = $listingType;

        return $this;
    }

    private function setGift(bool $gift) : ListingInfo
    {
        $this->gift = $gift;

        return $this;
    }

    private function setEndTime(string $endTime) : ListingInfo
    {
        $this->endTime = $endTime;

        return $this;
    }

    private function setConvertedBuyItNowPrice(string $currencyId, float $amount) : ListingInfo
    {
        $this->convertedBuyItNowPrice = array(
            'currencyId' => $currencyId,
            'amount' => $amount,
        );

        return $this;
    }

    private function setBuyItNowPrice(string $currencyId, float $amount) : ListingInfo
    {
        $this->buyItNowPrice = array(
            'currencyId' => $currencyId,
            'amount' => $amount,
        );

        return $this;
    }


    private function setBuyItNowAvailable($buyItNowAvailable) : ListingInfo
    {
        $this->buyItNowAvailable = $buyItNowAvailable;

        return $this;
    }

    private function setBestOfferEnabled($bestOfferEnabled) : ListingInfo
    {
        $this->bestOfferEnabled = $bestOfferEnabled;

        return $this;
    }
}