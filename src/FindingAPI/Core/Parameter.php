<?php

namespace FindingAPI\Core;

use FindingAPI\Core\Exception\RequestException;

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
     * @var array $possible
     */
    private $possible;

    /**
     * Parameter constructor.
     * @param array $parameter
     */
    public function __construct(array $parameter, array $possible)
    {
        $this
            ->setPossible($possible)
            ->setName($parameter['name'])
            ->setType($parameter['type'])
            ->setValue($parameter['value'])
            ->setValid($parameter['valid'])
            ->setSynonyms($parameter['synonyms']);

        ($parameter['deprecated'] === true) ? $this->setDeprecated() : $this->removeDeprecated();
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
    public function setName(string $name) : Parameter
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
    public function setType(string $type) : Parameter
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getValue() : string
    {
        $possible = $this->getPossible('type');
        $type = $this->getType();

        if (in_array($type, $possible) === false) {
            throw new RequestException('Value has to be '.$type.'. Possible types are'.implode(', ', $possible));
        }

        if ($type === 'required') {
            if (empty($this->value)) {
                throw new RequestException('Value for parameter '.$this->getName().' cannot be a value when empty() return true');
            }
        }

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
     * @return array
     */
    public function getPossible(string $type) : array
    {
        if (!array_key_exists($type, $this->possible)) {
            throw new RequestException('Possibility type '.$type.' not found');
        }

        return $this->possible[$type];
    }

    /**
     * @param array $possible
     * @return Parameter
     */
    public function setPossible(array $possible) : Parameter
    {
        $this->possible = $possible;

        return $this;
    }
}