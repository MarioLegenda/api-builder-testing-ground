<?php

namespace FindingAPI\Core\ResponseParser\ResponseItem;

class AbstractItemIterator extends AbstractItem implements \Iterator, \Countable
{
    /**
     * @var int $position
     */
    protected $position;
    /**
     * @var array $iterated
     */
    protected $iterated = array();
    /**
     * @param ResponseItemInterface $item
     * @return ResponseItemInterface
     */
    public function addItem(ResponseItemInterface $item) : ResponseItemInterface
    {
        $this->iterated[] = $item;

        return $this;
    }

    /**
     * @param string $itemName
     * @param ResponseItemInterface $item
     */
    public function addItemByName(string $itemName, ResponseItemInterface $item) : ResponseItemInterface
    {
        $this->iterated[$itemName] = $item;

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

        return $this->iterated[$position];
    }
    /**
     * @param $key
     * @return bool
     */
    public function hasItem($key) : bool
    {
        return array_key_exists($key, $this->iterated);
    }
    /**
     * @param \SimpleXMLElement $simpleXML
     * @param \Closure $callable
     */
    public function loadItemsAsync(\SimpleXMLElement $simpleXML, \Closure $callable)
    {
        $callable->call($this, $simpleXML);
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
        return $this->iterated[$this->position];
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
        return isset($this->iterated[$this->position]);
    }

    /**
     * @return int
     */
    public function count() : int
    {
        return count($this->iterated);
    }
}