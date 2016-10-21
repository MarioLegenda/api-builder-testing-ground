<?php

namespace FindingAPI\Core\ResponseParser\ResponseItem;

use FindingAPI\Core\ResponseParser\ResponseItem\Child\Item;

class AbstractItemIterator extends AbstractItem implements \IteratorAggregate
{
    /**
     * @var int $position
     */
    protected $position = 0;
    /**
     * @var array $items
     */
    protected $items = array();
    /**
     * @param ResponseItemInterface $item
     * @return ResponseItemInterface
     */
    public function addItem(ResponseItemInterface $item) : ResponseItemInterface
    {
        $this->items[] = $item;

        return $this;
    }
    /**
     * @param int $position
     * @return mixed|null
     */
    public function getItemByPosition(int $position)
    {
        if ($this->hasItem($position)) {
            return null;
        }

        return $this->items[$position];
    }
    /**
     * @param $key
     * @return bool
     */
    public function hasItem($key) : bool
    {
        return array_key_exists($key, $this->items);
    }
    /**
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->items);
    }
}