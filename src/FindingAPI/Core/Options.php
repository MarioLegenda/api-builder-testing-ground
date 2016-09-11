<?php

namespace FindingAPI\Core;

class Options
{
    /**
     *  const SMART_GUESS_SYSTEM
     */
    const SMART_GUESS_SYSTEM = 1;
    /**
     * @var array $options
     */
    private $options = array();

    /**
     * @param int $offset
     * @return Options
     */
    public function addOption(int $offset) : Options
    {
        $this->options[$offset] = true;

        return $this;
    }

    /**
     * @param int $offset
     * @return bool
     */
    public function removeOption(int $offset) : bool
    {
        if ($this->hasOption($offset)) {
            unset($this->options[$offset]);

            return true;
        }

        return false;
    }

    /**
     * @param int $offset
     * @return bool
     */
    public function hasOption(int $offset) : bool
    {
        return array_key_exists($offset, $this->options);
    }

    /**
     * @param int $offset
     * @return mixed|null
     */
    public function getOption(int $offset)
    {
        if (!$this->hasOption($offset)) {
            return null;
        }

        return $offset;
    }
}