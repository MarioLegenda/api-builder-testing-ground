<?php

namespace FindingAPI\Core\ResponseParser\ResponseItem;

use FindingAPI\Core\Debug\Debug;
use FindingAPI\Core\Exception\ResponseException;
use FindingAPI\Core\ResponseParser\ResponseItem\Child\Item;
use FindingAPI\Core\ResponseParser\ResponseItem\Child\PrimaryCategory;

class SearchResultsContainer extends AbstractItemIterator
{
    /**
     * @var bool $itemsLoaded
     */
    private $itemsLoaded = false;
    /**
     * @param string $itemId
     * @return mixed
     */
    public function getItemById(string $itemId) : Item
    {
        if ($this->itemsLoaded === false) {
            $this->loadItems($this->simpleXml);
        }

        return $this->iterated[$itemId];
    }
    /**
     * @param string $name
     * @return null
     */
    public function getItemByName(string $name)
    {
        if ($this->itemsLoaded === false) {
            $this->loadItems($this->simpleXml);
        }

        foreach ($this->iterated as $item) {
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

            $itemId = (string) $item->itemId;
            $this->addItemByName($itemId, $productItem);
        }

        $this->itemsLoaded = true;
    }
}