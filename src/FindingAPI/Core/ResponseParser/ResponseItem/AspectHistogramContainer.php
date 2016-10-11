<?php

namespace FindingAPI\Core\ResponseParser\ResponseItem;

use FindingAPI\Core\ResponseParser\ResponseItem\Child\Aspect;

class AspectHistogramContainer extends AbstractItem implements \Iterator
{
    /**
     * @var array $aspects
     */
    private $aspects = array();
    /**
     * @var int $position
     */
    private $position = 0;
    /**
     * @param ResponseItemInterface $aspect
     */
    public function addAspect(ResponseItemInterface $aspect)
    {
        $this->aspects[] = $aspect;
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
     * @return Aspect
     */
    public function current() : Aspect
    {
        return $this->aspects[$this->position];
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
        return isset($this->aspects[$this->position]);
    }
    /**
     * @param string $aspectName
     * @return array
     */
    public function getAspectByName(string $aspectName) : array
    {
        $aspects = array();
        foreach ($this->aspects as $aspect) {
            if ($aspect->getName() === $aspectName) {
                $this->aspects[] = $aspect;
            }
        }

        return $aspects;
    }
    /**
     * @param string $histogramName
     * @return array
     */
    public function getAspectByHistogramName(string $histogramName) : array
    {
        $aspects = array();
        foreach ($this->aspects as $aspect) {
            if ($aspect->getHistogramName() === $histogramName) {
                $this->aspects[] = $aspect;
            }
        }

        return $aspects;
    }
    /**
     * @param string $histogramValue
     * @return array
     */
    public function getAspectByHistogramValue(string $histogramValue) : array
    {
        $aspects = array();
        foreach ($this->aspects as $aspect) {
            if ($aspect->getHistogramValue() === $histogramValue) {
                $this->aspects[] = $aspect;
            }
        }

        return $aspects;
    }
    /**
     * @param int $position
     * @return mixed
     */
    public function getAspectByPosition(int $position)
    {
        if (array_key_exists($position, $this->aspects)) {
            return $this->aspects[$position];
        }

        return null;
    }
}