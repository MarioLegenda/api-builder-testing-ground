<?php

namespace FindingAPI\Core\ResponseParser\ResponseItem;

use FindingAPI\Core\Response\ArrayConvertableInterface;
use FindingAPI\Core\ResponseParser\ResponseItem\Child\Aspect\Aspect;

class AspectHistogramContainer extends AbstractItemIterator implements ArrayConvertableInterface, \JsonSerializable
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
    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->toArray();
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