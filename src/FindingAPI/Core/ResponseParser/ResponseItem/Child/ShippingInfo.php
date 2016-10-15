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
     * @param mixed $default
     * @return array
     */
    public function getShippingServiceCost($default = null)
    {
        if ($this->shippingServiceCost === null) {
            if (!empty($this->simpleXml->shippingServiceCost)) {
                $this->setShippingServiceCost(
                    (string) $this->simpleXml->shippingServiceCost['currencyId'],
                    (float) $this->simpleXml->shippingServiceCost
                );
            }
        }

        if ($default !== null) {
            return $default;
        }

        return $this->shippingServiceCost;
    }
    /**
     * @param mixed $default
     * @return bool|null
     */
    public function getExpeditedShipping($default = null)
    {
        if ($this->expeditedShipping === null) {
            if (!empty($this->simpleXml->expeditedShipping)) {
                $this->setExpeditedShipping((bool) $this->simpleXml->expeditedShipping);
            }
        }

        if ($default !== null) {
            return $default;
        }

        return $this->expeditedShipping;
    }

    /**
     * @param mixed $default
     * @return int
     */
    public function getHandlingTime($default = null) : int
    {
        if ($this->handlingTime === null) {
            if (!empty($this->simpleXml->handlingTime)) {
                $this->setHandlingTime((int) $this->simpleXml->handlingTime);
            }
        }

        if ($default !== null) {
            return $default;
        }

        return $this->handlingTime;
    }
    /**
     * @param mixed $default
     * @return int
     */
    public function getOneDayShippingAvailable($default = null) : int
    {
        if ($this->oneDayShippingAvailable === null) {
            if (!empty($this->simpleXml->oneDayShippingAvailable)) {
                $this->setOneDayShippingAvailable((bool) $this->simpleXml->oneDayShippingAvailable);
            }
        }

        if ($default !== null) {
            return $default;
        }

        return $this->oneDayShippingAvailable;
    }
    /**
     * @param mixed $default
     * @return string
     */
    public function getShippingType($default = null) : string
    {
        if ($this->shippingType === null) {
            if (!empty($this->simpleXml->shippingType)) {
                $this->setShippingType((string) $this->simpleXml->shippingType);
            }
        }

        if ($default !== null) {
            return $default;
        }

        return $this->shippingType;
    }
    /**
     * @param mixed $default
     * @return array
     */
    public function getShipToLocations($default = null) : array
    {
        if ($this->shipToLocations === null) {
            if (!empty($this->simpleXml->shipToLocations)) {
                $this->setShipToLocations($this->simpleXml->shipToLocations);
            }
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