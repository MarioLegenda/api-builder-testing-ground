<?php

namespace FindingAPI\Core\ResponseParser\ResponseItem;

use FindingAPI\Core\ResponseParser\ResponseItem\Child\ConditionHistogram\ConditionHistogram;

class ConditionHistogramContainer extends AbstractItemIterator
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

    private function loadContainer(\SimpleXMLElement $simpleXMLElement)
    {
        foreach ($simpleXMLElement->conditionHistogram as $conditionHistogram) {
            $this->addItem(new ConditionHistogram($conditionHistogram));
        }
    }
}