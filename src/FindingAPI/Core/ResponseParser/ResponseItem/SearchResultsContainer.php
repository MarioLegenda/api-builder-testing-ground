<?php

namespace FindingAPI\Core\ResponseParser\ResponseItem;

use FindingAPI\Core\Exception\ResponseException;
use FindingAPI\Core\ResponseParser\ResponseItem\Child\Item;
use FindingAPI\Core\ResponseParser\ResponseItem\Child\PrimaryCategory;

class SearchResultsContainer extends AbstractItemIterator
{
    /**
     * @param string $itemId
     * @return mixed
     */
    public function getItemById(string $itemId) : Item
    {
        if (!$this->hasItem($itemId)) {
            $this->loadItems($this->simpleXml);
        }

        return $this->iterated[$itemId];
    }

    private function loadItems(\SimpleXMLElement $simpleXml)
    {
        $items = $simpleXml->children();

        foreach ($items as $item) {
            $productItem = new Item($item);
            $itemId = (string) $item->itemId;

            $productItem->setTitle((string) $item->{'title'});
            $productItem->setGlobalId((string) $item->globalId);
            $productItem->setItemId((string) $item->itemId);

            $primaryCategory = new PrimaryCategory($item->primaryCategory);

            $productItem->setPrimaryCategory($primaryCategory);

            $this->addItemByName($itemId, $productItem);
        }
    }
}