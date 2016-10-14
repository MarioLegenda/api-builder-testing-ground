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
     * @var float $currentPrice
     */
    private $currentPrice;
    /**
     * @var float $sellingState
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
            $this->setBidCount((int) $this->simpleXml->bidCount);
        }

        return $this->bidCount;
    }
    /**
     * @return float|null
     */
    public function getConvertedCurrentPrice()
    {
        if ($this->convertedCurrentPrice === null) {
            $this->setConvertedCurrentPrice((float) $this->simpleXml->convertedCurrentPrice);
        }

        return $this->convertedCurrentPrice;
    }

    private function setConvertedCurrentPrice($convertedCurrentPrice)
    {
        $this->convertedCurrentPrice = $convertedCurrentPrice;

        return $this;
    }

    private function setBidCount($bidCount) : SellingStatus
    {
        $this->bidCount = $bidCount;

        return $this;
    }
}