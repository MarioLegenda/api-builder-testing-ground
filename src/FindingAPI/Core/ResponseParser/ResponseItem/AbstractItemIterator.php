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
     */
    public function addItem(ResponseItemInterface $item)
    {
        $this->iterated[] = $item;
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