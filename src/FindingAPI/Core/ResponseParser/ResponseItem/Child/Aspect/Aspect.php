<?php

namespace FindingAPI\Core\ResponseParser\ResponseItem\Child\Aspect;

use FindingAPI\Core\ResponseParser\ResponseItem\AbstractItemIterator;

class Aspect extends AbstractItemIterator
{
    /**
     * @var string $aspectName
     */
    private $aspectName;
    /**
     * @param null $default
     * @return null|string
     */
    public function getAspectName($default = null)
    {
        if ($this->aspectName === null) {
            if (!empty($this->simpleXml->aspect['name'])) {
                $this->setAspectName($this->simpleXml->aspect['name']);
            }
        }

        if ($this->aspectName === null and $default !== null) {
            return $default;
        }

        return $this->aspectName;
    }
    /**
     * @param null|mixed $default
     */
    public function getValuesHistograms($default = null)
    {
        if ($this->isEmpty()) {
            $this->loadValueHistograms($this->simpleXml);
        }

        if ($this->isEmpty() and $default !== null) {
            return $default;
        }

        if (!$this->isEmpty()) {
            return $this->items;
        }
    }

    private function loadValueHistograms(\SimpleXMLElement $simpleXml)
    {
        if (!empty($simpleXml->valueHistogram)) {
            foreach ($simpleXml->valueHistogram as $valueHistogram) {
                $this->setValueHistogram(new ValueHistogram($valueHistogram));
            }
        }
    }

    private function setValueHistogram(ValueHistogram $valueHistogram) : Aspect
    {
        $this->addItem($valueHistogram);

        return $this;
    }

    private function setAspectName(string $aspectName) : Aspect
    {
        $this->aspectName = $aspectName;

        return $this;
    }
}