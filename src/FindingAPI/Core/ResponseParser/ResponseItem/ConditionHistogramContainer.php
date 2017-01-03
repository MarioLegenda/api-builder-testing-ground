<?php

namespace FindingAPI\Core\ResponseParser\ResponseItem;

use FindingAPI\Core\Response\ArrayConvertableInterface;
use FindingAPI\Core\ResponseParser\ResponseItem\Child\ConditionHistogram\ConditionHistogram;

class ConditionHistogramContainer extends AbstractItemIterator implements ArrayConvertableInterface
{
    /**
     * ConditionHistogramContainer constructor.
     * @param \SimpleXMLElement $simpleXML
     */
    public function __construct(\SimpleXMLElement $simpleXML)
    {
        parent::__construct($simpleXML);

        $this->loadContainer($simpleXML);
    }
    /**
     * @return array
     */
    public function toArray(): array
    {
        $toArray = array();

        foreach ($this->items as $item) {
            $toArray[] = $item->toArray();
        }

        return $toArray;
    }

    private function loadContainer(\SimpleXMLElement $simpleXMLElement)
    {
        foreach ($simpleXMLElement->conditionHistogram as $conditionHistogram) {
            $this->addItem(new ConditionHistogram($conditionHistogram));
        }
    }
}