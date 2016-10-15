<?php

namespace FindingAPI\Core\ResponseParser\ResponseItem\Child\Item;

use FindingAPI\Core\ResponseParser\ResponseItem\AbstractItem;

class Attribute extends AbstractItem
{
    /**
     * @var string $attributeName
     */
    private $attributeName;
    /**
     * @var string $attributeValue
     */
    private $attributeValue;
    /**
     * @param null $default
     * @return null|string
     */
    public function getAttributeName($default = null)
    {
        if ($this->attributeName === null) {
            if (!empty($this->simpleXml->name)) {
                $this->setAttributeName((string) $this->simpleXml->name);
            }
        }

        if ($default !== null) {
            return $default;
        }

        return $this->attributeName;
    }
    /**
     * @param null $default
     * @return null|string
     */
    public function getAttributeValue($default = null)
    {
        if ($this->attributeValue === null) {
            if (!empty($this->simpleXml->value)) {
                $this->setAttributeValue((string) $this->simpleXml->value);
            }
        }

        if ($default !== null) {
            return $default;
        }

        return $this->attributeValue;
    }

    private function setAttributeValue(string $attributeValue) : Attribute
    {
        $this->attributeValue = $attributeValue;

        return $this;
    }

    private function setAttributeName(string $attributeName) : Attribute
    {
        $this->attributeName = $attributeName;

        return $this;
    }
}