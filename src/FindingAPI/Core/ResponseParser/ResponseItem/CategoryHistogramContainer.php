<?php

namespace FindingAPI\Core\ResponseParser\ResponseItem;

use FindingAPI\Core\Response\ArrayConvertableInterface;
use FindingAPI\Core\ResponseParser\ResponseItem\Child\CategoryHistogram\CategoryHistogram;

class CategoryHistogramContainer extends AbstractItemIterator implements ArrayConvertableInterface
{
    /**
     * CategoryHistogramContainer constructor.
     * @param \SimpleXMLElement $simpleXML
     */
    public function __construct(\SimpleXMLElement $simpleXML)
    {
        parent::__construct($simpleXML);

        $this->loadCategoryHistograms($simpleXML);
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

    private function loadCategoryHistograms(\SimpleXMLElement $simpleXml)
    {
        foreach ($simpleXml->categoryHistogram as $categoryHistogram) {
            $this->addItem(new CategoryHistogram($categoryHistogram));
        }
    }
}