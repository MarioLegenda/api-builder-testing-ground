<?php

namespace FindingAPI\Core\ResponseParser\ResponseItem;

use FindingAPI\Core\ResponseParser\ResponseItem\Child\Aspect\Aspect;

class AspectHistogramContainer extends AbstractItemIterator
{
    /**
     * ConditionHistogramContainer constructor.
     * @param \SimpleXMLElement $simpleXML
     */
    public function __construct(\SimpleXMLElement $simpleXML)
    {
        parent::__construct($simpleXML);

        $this->loadAspects($simpleXML);
    }

    private function loadAspects(\SimpleXMLElement $simpleXml)
    {
        if (!empty($simpleXml->aspect)) {
            foreach ($simpleXml->aspect as $aspect) {
                $this->addItem(new Aspect($aspect));
            }
        }
    }
}