<?php

namespace FindingAPI\Core\ResponseParser\ResponseItem;

use FindingAPI\Core\Response\ArrayConvertableInterface;
use FindingAPI\Core\ResponseParser\ResponseItem\Child\Aspect\Aspect;

class AspectHistogramContainer extends AbstractItemIterator implements ArrayConvertableInterface, \JsonSerializable
{
    /**
     * @var string $domainDisplayName
     */
    private $domainDisplayName;
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
     * @param null $default
     * @return null|string
     */
    public function getDomainDisplayName($default = null)
    {
        if ($this->domainDisplayName === null) {
            if (!empty($this->simpleXml->domainDisplayName)) {
                $this->setDomainDisplayName((string) $this->simpleXml->domainDisplayName);
            }
        }

        if ($this->domainDisplayName === null and $default !== null) {
            return $default;
        }

        return $this->domainDisplayName;
    }
    /**
     * @return array
     */
    public function toArray(): array
    {
        $toArray = array();

        $toArray['domainDisplayName'] = $this->getDomainDisplayName();

        $toArray['aspects'] = array();

        foreach ($this->items as $item) {
            $toArray['aspects'][] = $item->toArray();
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

    private function setDomainDisplayName(string $domainDisplayName)
    {
        $this->domainDisplayName = $domainDisplayName;
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