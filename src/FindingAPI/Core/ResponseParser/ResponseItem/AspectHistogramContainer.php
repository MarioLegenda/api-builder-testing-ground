<?php

namespace FindingAPI\Core\ResponseParser\ResponseItem;

class AspectHistogramContainer extends AbstractItemIterator
{
    /**
     * @param string $aspectName
     * @return array
     */
    public function getAspectByName(string $aspectName) : array
    {
        $aspects = array();
        foreach ($this->iterated as $aspect) {
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