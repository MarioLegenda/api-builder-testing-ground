<?php

namespace FindingAPI\Core\ResponseParser\ResponseItem;

use FindingAPI\Core\ResponseParser\ResponseItem\Child\Item;

class AbstractItemIterator extends AbstractItem implements \Iterator, \Countable
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
     * @return \Iterator
     */
    public function rewind() : \Iterator
    {
        $this->position = 0;

        return $this;
    }

    /**
     * @return mixed
     */
    public function current()
    {
        return $this->items[$this->position];
    }

    /**
     * @return int
     */
    public function key() : int
    {
        return $this->position;
    }

    /**
     * @return \Iterator
     */
    public function next() : \Iterator
    {
        ++$this->position;

        return $this;
    }

    /**
     * @return bool
     */
    public function valid() : bool
    {
        return $this->hasItem($this->position);
    }

    /**
     * @return int
     */
    public function count() : int
    {
        return count($this->items);
    }
}