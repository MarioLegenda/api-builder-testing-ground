<?php

namespace FindingAPI\Core\ResponseParser\ResponseItem\Child;

use FindingAPI\Core\ResponseParser\ResponseItem\AbstractItem;
use FindingAPI\Core\ResponseParser\ResponseItem\AbstractItemIterator;

class Item extends AbstractItemIterator
{
    /**
     * @var string $globalId
     */
    private $globalId;
    /**
     * @var string $title
     */
    private $title;
    /**
     * @var string $itemId
     */
    private $itemId;
    /**
     * @param string $itemId
     * @return Item
     */
    public function setItemId(string $itemId) : Item
    {
        $this->itemId = $itemId;

        return $this;
    }
    /**
     * @return string
     */
    public function getItemId() : string
    {
        return $this->itemId;
    }
    /**
     * @param string $title
     * @return Item
     */
    public function setTitle(string $title) : Item
    {
        $this->title = $title;

        return $this;
    }
    /**
     * @return string
     */
    public function getTitle() : string
    {
        return $this->title;
    }
    /**
     * @param string $globalId
     * @return Item
     */
    public function setGlobalId(string $globalId) : Item
    {
        $this->globalId = $globalId;

        return $this;
    }
    /**
     * @return string
     */
    public function getGlobalId() : string
    {
        return $this->globalId;
    }
}