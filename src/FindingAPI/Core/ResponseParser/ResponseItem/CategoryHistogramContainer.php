<?php

namespace FindingAPI\Core\ResponseParser\ResponseItem;

use FindingAPI\Core\ResponseParser\ResponseItem\Child\CategoryHistogram\CategoryHistogram;

class CategoryHistogramContainer extends AbstractItemIterator
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

    private function loadCategoryHistograms(\SimpleXMLElement $simpleXml)
    {
        foreach ($simpleXml->categoryHistogram as $categoryHistogram) {
            $this->addItem(new CategoryHistogram($categoryHistogram));
        }
    }
}