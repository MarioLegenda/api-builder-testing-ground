<?php

namespace FindingAPI\Core\ResponseParser\ResponseItem\Child;

class ShippingInfo
{
    /**
     * @var \SimpleXMLElement $simpleXml
     */
    private $simpleXml;

    /**
     * @var array $shippingServiceCost
     */
    private $shippingServiceCost;
    /**
     * @var bool $expeditedShipping
     */
    private $expeditedShipping;
    /**
     * @var int $handlingTime
     */
    private $handlingTime;
    /**
     * @var bool $oneDayShippingAvailable
     */
    private $oneDayShippingAvailable;
    /**
     * @var string $shippingType
     */
    private $shippingType;
    /**
     * @var array $shipToLocations
     */
    private $shipToLocations;
    /**
     * ShippingInfo constructor.
     * @param \SimpleXMLElement $simpleXml
     */
    public function __construct(\SimpleXMLElement $simpleXml)
    {
        $this->simpleXml = $simpleXml;
    }
    /**
     * @return array
     */
    public function getShippingServiceCost()
    {
        if ($this->shippingServiceCost === null) {
            $this->setShippingServiceCost(
                (string) $this->simpleXml->shippingServiceCost['currencyId'],
                (float) $this->simpleXml->shippingServiceCost
            );
        }

        return $this->shippingServiceCost;
    }
    /**
     * @return bool|null
     */
    public function getExpeditedShipping()
    {
        if ($this->expeditedShipping === null) {
            $this->setExpeditedShipping((bool) $this->simpleXml->expeditedShipping);
        }

        return $this->expeditedShipping;
    }

    /**
     * @return int
     */
    public function getHandlingTime() : int
    {
        if ($this->handlingTime === null) {
            $this->setHandlingTime((int) $this->simpleXml->handlingTime);
        }

        return $this->handlingTime;
    }
    /**
     * @return int
     */
    public function getOneDayShippingAvailable() : int
    {
        if ($this->oneDayShippingAvailable === null) {
            $this->setOneDayShippingAvailable((bool) $this->simpleXml->oneDayShippingAvailable);
        }

        return $this->oneDayShippingAvailable;
    }
    /**
     * @return string
     */
    public function getShippingType() : string
    {
        if ($this->shippingType === null) {
            $this->setShippingType((string) $this->simpleXml->shippingType);
        }

        return $this->shippingType;
    }
    /**
     * @return array
     */
    public function getShipToLocations() : array
    {
        if ($this->shipToLocations === null) {
            $this->setShipToLocations($this->simpleXml->shipToLocations);
        }

        return $this->shipToLocations;
    }

    private function setShipToLocations($locations) : ShippingInfo
    {
        foreach ($locations as $location) {
            $this->shipToLocations[] = (string) $location;
        }

        return $this;
    }

    private function setShippingType(string $shippingType) : ShippingInfo
    {
        $this->shippingType = $shippingType;

        return $this;
    }

    private function setOneDayShippingAvailable(bool $oneDayShippingAvailable) : ShippingInfo
    {
        $this->oneDayShippingAvailable = $oneDayShippingAvailable;

        return $this;
    }

    private function setHandlingTime(int $handlingTime) : ShippingInfo
    {
        $this->handlingTime = $handlingTime;

        return $this;
    }

    private function setShippingServiceCost(string $currencyId, float $amount) : ShippingInfo
    {
        $this->shippingServiceCost = array(
            'currencyId' => $currencyId,
            'amount' => $amount,
        );

        return $this;
    }

    private function setExpeditedShipping(bool $expeditedShipping) : ShippingInfo
    {
        $this->expeditedShipping = $expeditedShipping;

        return $this;
    }
}