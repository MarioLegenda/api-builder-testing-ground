<?php

namespace FindingAPI\Core\Event;

use FindingAPI\Core\ItemFilter\ItemFilterStorage;
use Symfony\Component\EventDispatcher\Event;

class ItemFilterEvent extends Event
{
    /**
     * @var ItemFilterStorage $itemFilterStorage
     */
    private $itemFilterStorage;
    /**
     * ItemFilterEvent constructor.
     * @param ItemFilterStorage $itemFilterStorage
     */
    public function __construct(ItemFilterStorage $itemFilterStorage)
    {
        $this->itemFilterStorage = $itemFilterStorage;
    }
    /**
     * @return ItemFilterStorage
     */
    public function getItemFilterStorage()
    {
        return $this->itemFilterStorage;
    }
}