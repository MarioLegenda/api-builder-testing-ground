<?php

namespace FindingAPI\Core\Options;

class Options
{
    const GLOBAL_ITEM_FILTERS = 'global_item_filters';
    const INDIVIDUAL_ITEM_FILTERS = 'individual_item_filters';

    /**
     * @var array $options
     */
    private $options = array();
    /**
     * @param Option $option
     * @return Options
     */
    public function addOption(Option $option) : Options
    {
        $this->options[$option->getName()] = $option;

        return $this;
    }
    /**
     * @param string $option
     * @return mixed|null
     */
    public function getOption(string $option)
    {
        if (array_key_exists($option, $this->options)) {
            return $this->options[$option];
        }

        foreach ($this->options as $opt) {
            if ($opt->getName() === $option) {
                return $opt;
            }
        }

        return null;
    }

    /**
     * @param string $name
     * @param $value
     * @return Option|null
     */
    public function modifyOption(string $name, $value)
    {
        if ($this->hasOption($name)) {
            $option = $this->getOption($name);
            $option->setValue($value);

            return $option;
        }

        return null;
    }
    /**
     * @param string $option
     * @return bool
     */
    public function hasOption(string $option) : bool
    {
        if (array_key_exists($option, $this->options)) {
            return true;
        }

        foreach ($this->options as $option) {
            if ($option->getName() === $option) {
                return true;
            }
        }

        return false;
    }
}