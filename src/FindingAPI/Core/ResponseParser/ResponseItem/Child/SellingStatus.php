<?php

namespace FindingAPI\Core\ResponseParser\ResponseItem\Child;

class SellingStatus
{
    /**
     * @var \SimpleXMLElement $simpleXml
     */
    private $simpleXml;

    /**
     * @var int $bidCount
     */
    private $bidCount;
    /**
     * @var float $convertedCurrentPrice
     */
    private $convertedCurrentPrice;
    /**
     * @var array $currentPrice
     */
    private $currentPrice;
    /**
     * @var string $sellingState
     */
    private $sellingState;
    /**
     * @var int $timeLeft
     */
    private $timeLeft;

    /**
     * @return int|null
     */
    public function getBidCount()
    {
        if ($this->bidCount === null) {
            if (!empty($this->simpleXml->bidCount)) {
                $this->setBidCount((int) $this->simpleXml->bidCount);
            }
        }

        return $this->bidCount;
    }
    /**
     * @return float|null
     */
    public function getConvertedCurrentPrice()
    {
        if ($this->convertedCurrentPrice === null) {
            if (!empty($this->simpleXml->convertedCurrentPrice)) {
                $this->setConvertedCurrentPrice((string) $this->simpleXml->convertedCurrentPrice['currencyId'], (float) $this->simpleXml->convertedCurrentPrice);
            }
        }

        return $this->convertedCurrentPrice;
    }

    /**
     * @return float|null
     */
    public function getCurrentPrice()
    {
        if ($this->currentPrice === null) {
            if (!empty($this->simpleXml->currentPrice)) {
                $this->setCurrentPrice((string) $this->simpleXml->currentPrice['currencyId'], (float) $this->simpleXml->currentPrice);
            }
        }

        return $this->currentPrice;
    }

    /**
     * @return string
     */
    public function getSellingState()
    {
        if ($this->sellingState === null) {
            if (!empty($this->simpleXml->sellingState)) {
                $this->setSellingState((string) $this->simpleXml->sellingState);
            }
        }

        return $this->sellingState;
    }
    /**
     * @return int|null
     */
    public function getTimeLeft()
    {
        if ($this->timeLeft === null) {
            if (!empty($this->simpleXml->timeLeft)) {
                $this->setTimeLeft((string) $this->simpleXml->timeLeft);
            }
        }

        return $this->timeLeft;
    }

    private function setTimeLeft($timeLeft) : SellingStatus
    {
        $this->timeLeft = $timeLeft;

        return $this;
    }

    private function setSellingState($sellingState) : SellingStatus
    {
        $this->sellingState = $sellingState;

        return $this;
    }

    private function setCurrentPrice($currencyId, $currentPrice) : SellingStatus
    {
        $this->currentPrice = array(
            'currencyId' => $currencyId,
            'currenctPrice' => $currentPrice,
        );

        return $this;
    }

    private function setConvertedCurrentPrice($currencyId, $convertedCurrentPrice)
    {
        $this->convertedCurrentPrice = array(
            'currencyId' => $currencyId,
            'convertedCurrentPrice' => $convertedCurrentPrice,
        );

        return $this;
    }

    private function setBidCount($bidCount) : SellingStatus
    {
        $this->bidCount = $bidCount;

        return $this;
    }
}