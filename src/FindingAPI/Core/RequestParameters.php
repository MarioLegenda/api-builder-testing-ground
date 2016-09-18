<?php

namespace FindingAPI\Core;

use FindingAPI\Core\Exception\DeprecatedException;
use FindingAPI\Core\Exception\RequestException;

class RequestParameters implements \IteratorAggregate
{
    /**
     * const string
     */
    const REQUEST_METHOD_POST = 'POST';
    /**
     * const string
     */
    const REQUEST_METHOD_GET = 'GET';
    /**
     * const string
     */
    const RESPONSE_DATA_FORMAT_XML = 'xml';
    /**
     * const string
     */
    const RESPONSE_DATA_FORMAT_JSON = 'json';
    /**
     * @var array|null $parameters
     */
    private $parameters;
    /**
     * RequestParameters constructor.
     * @param array|null $parameters
     */
    public function __construct(array $parameters, array $possible)
    {
        foreach ($parameters as $parameter) {
            $this->parameters[] = new Parameter($parameter, $possible);
        }
    }
    /**
     * @param string $name
     * @return RequestParameters
     * @throws RequestException
     */
    public function markDeprecated(string $name) : RequestParameters
    {
        if (!$this->hasParameter($name)) {
            throw new RequestException('Parameter '.$name.' does not exist and cannot be deprecated');
        }

        $this->getParameter($name)->setDeprecated();

        return $this;
    }
    /**
     * @param string $name
     * @return RequestParameters
     * @throws RequestException
     */
    public function unmarkDeprecated(string $name) : RequestParameters
    {
        if (!$this->hasParameter($name)) {
            throw new RequestException('Parameter '.$name.' does not exist and cannot be deprecated');
        }

        $this->getParameter($name)->removeDeprecated();

        return $this;
    }
    /**
     * @param string $name
     * @return bool
     * @throws RequestException
     */
    public function isDeprecated(string $name) : bool
    {
        if (!$this->hasParameter($name)) {
            throw new RequestException('Parameter '.$name.' does not exist and cannot be deprecated');
        }

        return $this->getParameter($name)->isDeprecated();
    }
    /**
     * @param string $name
     * @param string $value
     * @param string $type
     * @return RequestParameters
     * @throws RequestException
     */
    public function setParameter(string $name, string $value) : RequestParameters
    {
        if (!$this->hasParameter($name)) {
            throw new RequestException('Unknown request parameter '.$name.'. If you which to add a new parameter, use Request::__construct(array $parameters) and add the new parameters there. The new parameter will be appended on the existing ones');
        }

        if (!$this->isValidParameter($name, $value)) {
            throw new RequestException('Invalid parameter given for '.$name.' with value '.$value);
        }

        $this->getParameter($name)->setValue($value);
        $this->getParameter($name)->setName($name);

        return $this;
    }
    /**
     * @param string $name
     * @param string $value
     * @param string $type
     * @param array $valids
     * @param array $synonyms
     * @return RequestParameters
     * @throws RequestException
     */
    public function addParameter(string $name, string $value, string $type, array $valids = array(), $synonyms = array()) : RequestParameters
    {
        if ($this->hasParameter($name)) {
            throw new RequestException('Request parameter '.$name.' already exists. If you which to replace it, use RequestParameters::replaceParameter()');
        }

        $options = array(
            'name' => $name,
            'type' => $type,
            'value' => $value,
            'deprecated' => false,
            'valid' => $valids,
            'synonyms' => null,
        );

        if (!empty($valids)) {
            $options['valid'] = $valids;
        }

        if (!empty($synonyms)) {
            $options['synonyms'] = $synonyms;
        }

        $this->parameters[] = new Parameter($options);

        return $this;
    }
    /**
     * @param string $name
     * @param string $value
     * @param string $type
     * @param array $valids
     * @param array $synonyms
     * @return RequestParameters
     * @throws RequestException
     */
    public function replaceParameter(string $name, string $value, string $type, $valids = array()) : RequestParameters
    {
        if (!$this->hasParameter($name)) {
            throw new RequestException('Request parameter '.$name.' does not exist. If you which to add a parameter, use RequestParameters::addParameter()');
        }

        $parameter = $this->getParameter($name);

        $parameter
            ->setName($name)
            ->addSynonym($name)
            ->addValid($valids)
            ->setValue($value)
            ->setType($type);

        return $this;
    }
    /**
     * @param string $name
     * @return bool
     * @throws RequestException
     */
    public function removeParameter(string $name) : bool
    {
        if (!$this->hasParameter($name)) {
            throw new RequestException('Request parameter '.$name.' does not exist');
        }

        unset($this->parameters[$name]);

        return true;
    }
    /**
     * @param string $name
     * @return mixed
     */
    public function getParameter(string $name)
    {
        if (!$this->hasParameter($name)) {
            return null;
        }

        foreach ($this->parameters as $parameter) {
            if ($parameter->hasSynonym($name)) {
                return $parameter;
            }

            if ($parameter->getName() === $name) {
                return $parameter;
            }
        }
    }
    /**
     * @param string $name
     * @return bool
     */
    public function hasParameter(string $name) : bool
    {
        foreach ($this->parameters as $parameter) {
            if ($parameter->hasSynonym($name)) {
                return true;
            }

            if ($parameter->getName() === $name) {
                return true;
            }
        }

        return false;
    }
    /**
     * @param string $name
     * @param string $value
     * @return bool
     */
    public function isValidParameter(string $name, string $value) : bool
    {
        if (!$this->hasParameter($name)) {
            return false;
        }

        $parameter = $this->getParameter($name);

        if ($parameter->isDeprecated()) {
            throw new DeprecatedException('Request parameter '.$name.' seems to be deprecated. If you which to ignore it, catch DeprecatedException');
        }

        if (!$parameter->isValid($value)) {
            throw new RequestException('Parameter '.$name.' exists but is not valid. This means that ebay supports exact list of values for this parameter. Valid values for this parameter are '.implode(', ', $parameter->getValid()));
        }

        return true;
    }
    /**
     * @return bool
     */
    public function valid() : bool
    {
        foreach ($this->parameters as $parameter) {
            if (array_key_exists('required', $parameter)) {
                if ($parameter['value'] === null) {
                    return false;
                }
            }
        }

        return true;
    }
    /**
     * @return \ArrayIterator
     */
    public function getIterator() : \ArrayIterator
    {
        return new \ArrayIterator($this->parameters);
    }
}