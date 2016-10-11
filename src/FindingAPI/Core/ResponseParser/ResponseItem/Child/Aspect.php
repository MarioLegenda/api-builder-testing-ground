<?php

namespace FindingAPI\Core\ResponseParser\ResponseItem\Child;

use FindingAPI\Core\ResponseParser\ResponseItem\AbstractItem;
use FindingAPI\Core\ResponseParser\ResponseItem\ResponseItemInterface;

class Aspect extends AbstractItem implements ResponseItemInterface
{
    /**
     * @var string $valueHistogramName
     */
    private $valueHistogramName;
    /**
     * @var $valueHistogramValue
     */
    private $valueHistogramValue;
    /**
     * Aspect constructor.
     * @param string $name
     * @param string $valueHistogramName
     * @param string $valueHistogramValue
     */
    public function __construct(string $name, string $valueHistogramName, string $valueHistogramValue)
    {
        parent::__construct($name);
    }
    /**
     * @return string
     */
    public function getValueHistogramName() : string
    {
        return $this->valueHistogramName;
    }
    /**
     * @return string
     */
    public function getValueHistogramValue() : string
    {
        return $this->valueHistogramValue;
    }
}