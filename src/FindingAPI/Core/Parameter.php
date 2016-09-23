<?php

namespace FindingAPI\Core;

use FindingAPI\Core\Exception\RequestException;

class Parameter
{
    /**
     * @var string $name
     */
    private $name = null;
    /**
     * @var string $type
     */
    private $type = null;
    /**
     * @var string $value
     */
    private $value = null;
    /**
     * @var bool $deprecated
     */
    private $deprecated = false;
    /**
     * @var array $valid
     */
    private $valid = array();
    /**
     * @var array $synonyms
     */
    private $synonyms = array();

    /**
     * Parameter constructor.
     * @param array $parameter
     */
    public function __construct(array $parameter = null)
    {
        if (!empty($parameter)) {
            $this
                ->setName($parameter['name'])
                ->setType($parameter['type'])
                ->setValid($parameter['valid'])
                ->setValue($parameter['value'])
                ->setSynonyms($parameter['synonyms']);

            ($parameter['deprecated'] === true) ? $this->setDeprecated() : $this->removeDeprecated();
        }
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
     * @throws RequestException
     */
    public function setName(string $name) : Parameter
    {
        if (empty($name)) {
            throw new RequestException('$name parameter cannot be an empty string. Given name: '.$name);
        }

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
    public function setType(string $type) : Parameter
    {
        $allowedTypes = array('required', 'optional');

        if (in_array($type, $allowedTypes) === false) {
            throw new RequestException('Invalid $type. Allowed types are '.implode(', ', $allowedTypes).' for Parameter '.$this->getName());
        }

        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getValue()
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
    /**
     * @return bool
     * @throws RequestException
     */
    public function validateParameter()
    {
        $type = $this->getType();
        $value = $this->getValue();

        if ($type === 'required') {
            if (empty($value)) {
                throw new RequestException('If $type is \'required\', then $value should not be empty for Parameter '.$this->getName());
            }
        }

        $valids = $this->getValid();
        if (!empty($valids)) {
            if (in_array($value, $valids) === false) {
                throw new RequestException('If $valid is provided for '.$this->getName().', then $value should be one of '.implode(', ', $valids));
            }
        }
    }
}