<?php

namespace FindingAPI\Core\ResponseParser\ResponseItem;

use FindingAPI\Core\ResponseParser\ResponseItem\Child\Item\Item;

class SearchResultsContainer extends AbstractItemIterator
{
    /**
     * SearchResultsContainer constructor.
     * @param \SimpleXMLElement $simpleXML
     */
    public function __construct(\SimpleXMLElement $simpleXML)
    {
        parent::__construct($simpleXML);

        $this->loadItems($simpleXML);
    }
    /**
     * @param string $itemId
     * @return mixed
     */
    public function getItemById(string $itemId) : Item
    {
        foreach ($this->items as $item) {
            if ($item->getItemId() === $itemId) {
                return $item;
            }
        }
    }
    /**
     * @param string $name
     * @return null
     */
    public function getItemByName(string $name)
    {
        foreach ($this->items as $item) {
            if ($item->getTitle() === $name) {
                return $item;
            }
        }

        return null;
    }

    private function loadItems(\SimpleXMLElement $simpleXml)
    {
        $items = $simpleXml->children();

        foreach ($items as $item) {
            $productItem = new Item($item);

            $this->addItem($productItem);
        }
    }
}