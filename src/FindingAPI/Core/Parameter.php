<?php

namespace FindingAPI\Core;

class Parameter
{
    /**
     * @var string $name
     */
    private $name;
    /**
     * @var string $type
     */
    private $type;
    /**
     * @var string $value
     */
    private $value;
    /**
     * @var bool $deprecated
     */
    private $deprecated;
    /**
     * @var array $valid
     */
    private $valid;
    /**
     * @var array $synonyms
     */
    private $synonyms;

    /**
     * Parameter constructor.
     * @param array $parameter
     */
    public function __construct(array $parameter)
    {
        $this->setName($parameter['name']);
        $this->setType($parameter['type']);
        $this->setValue($parameter['value']);
        ($parameter['deprecated'] === true) ? $this->setDeprecated() : $this->removeDeprecated();
        $this->setValid($parameter['valid']);
        $this->setSynonyms($parameter['synonyms']);
    }

    /**
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Parameter
     */
    public function setName($name) : Parameter
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getType() : string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return Parameter
     */
    public function setType($type) : Parameter
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getValue() : string
    {
        return $this->value;
    }

    /**
     * @param string $value
     * @return Parameter
     */
    public function setValue($value) : Parameter
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isDeprecated() : bool
    {
        return $this->deprecated;
    }

    /**
     * @param boolean $deprecated
     * @return Parameter
     */
    public function setDeprecated() : Parameter
    {
        $this->deprecated = true;

        return $this;
    }

    /**
     * @return Parameter
     */
    public function removeDeprecated() : Parameter
    {
        $this->deprecated = false;

        return $this;
    }

    /**
     * @return array
     */
    public function getValid() : array
    {
        return $this->valid;
    }

    /**
     * @param array $valid
     * @return Parameter
     */
    public function setValid(array $valid) : Parameter
    {
        $this->valid = $valid;

        return $this;
    }

    /**
     * @param array $valid
     * @return Parameter
     */
    public function addValid(array $valid) : Parameter
    {
        $this->valid = array_merge($valid);

        return $this;
    }

    /**
     * @param string $value
     * @return bool
     */
    public function isValid(string $value) : bool
    {
        if (empty($this->valid)) {
            return true;
        }

        return in_array($value, $this->valid);
    }

    /**
     * @param array $synonym
     * @return Parameter
     */
    public function addSynonym(array $synonym) : Parameter
    {
        $this->synonyms = array_merge($synonym);

        return $this;
    }

    /**
     * @return array
     */
    public function getSynonyms() : array
    {
        return $this->synonyms;
    }

    /**
     * @param array $synonyms
     * @return Parameter
     */
    public function setSynonyms(array $synonyms) : Parameter
    {
        $this->synonyms = $synonyms;

        return $this;
    }

    /**
     * @param $synonym
     * @return bool
     */
    public function hasSynonym($synonym) : bool
    {
        return in_array($synonym, $this->synonyms);
    }
}