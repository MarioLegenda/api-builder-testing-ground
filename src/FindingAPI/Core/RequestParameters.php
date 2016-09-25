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
     * @var bool $isDeadlocked
     */
    private $isDeadlocked = false;
    /**
     * @var array $excluded
     */
    private $excluded = array();
    /**
     * RequestParameters constructor.
     * @param array|null $parameters
     */
    public function __construct(array $parameters)
    {
        foreach ($parameters as $parameter) {
            $this->parameters[] = new Parameter($parameter);
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
        if ($this->isLocked()) {
            throw new RequestException('RequestParameters object is locked. Unclock it with RequestParameters::unlock()');
        }

        if (!$this->hasParameter($name)) {
            throw new RequestException('Unknown request parameter '.$name.'. If you which to add a new parameter, use Request::__construct(array $parameters) and add the new parameters there. The new parameter will be appended on the existing ones');
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
     * @param array $possible
     * @return RequestParameters
     * @throws RequestException
     */
    public function addParameter(Parameter $parameter) : RequestParameters
    {
        if ($this->isLocked()) {
            throw new RequestException('RequestParameters object is locked. Unclock it with RequestParameters::unlock()');
        }

        if ($this->hasParameter($parameter->getName())) {
            throw new RequestException($parameter->getName().' already exists');
        }

        $parameter->validateParameter();

        $this->parameters[] = $parameter;

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
    public function replaceParameter(Parameter $parameter) : RequestParameters
    {
        if ($this->isLocked()) {
            throw new RequestException('RequestParameters object is locked. Unclock it with RequestParameters::unlock()');
        }

        if (!$this->hasParameter($parameter->getName())) {
            throw new RequestException('Request parameter '.$parameter->getName().' does not exist. If you which to add a parameter, use RequestParameters::addParameter()');
        }

        $this->removeParameter($parameter)->addParameter($parameter);

        return $this;
    }
    /**
     * @param string $name
     * @return bool
     * @throws RequestException
     */
    public function removeParameter(Parameter $parameterToDelete) : RequestParameters
    {
        if ($this->isLocked()) {
            throw new RequestException('RequestParameters object is locked. Unclock it with RequestParameters::unlock()');
        }

        if (!$this->hasParameter($parameterToDelete->getName())) {
            throw new RequestException('Request parameter '.$parameterToDelete->getName().' does not exist');
        }

        foreach ($this->parameters as $key => $parameter) {
            if ($parameter->getName() === $parameterToDelete->getName()) {
                unset($this->parameters[$key]);

                return $this;
            }
        }

        return $this;
    }
    /**
     * @param string $name
     * @return mixed
     */
    public function getParameter(string $name) : Parameter
    {
        if (!$this->hasParameter($name)) {
            throw new RequestException('Unknown parameter '.$name);
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
     * @void
     */
    public function lock()
    {
        $this->isDeadlocked = true;
    }

    /**
     * @void
     */
    public function unlock()
    {
        $this->isDeadlocked = false;
    }
    /**
     * @return bool
     */
    public function isLocked() : bool
    {
        return $this->isDeadlocked;
    }
    /**
     * @return bool
     */
    public function valid()
    {
        foreach ($this->parameters as $parameter) {
            $parameter->validateParameter();
        }
    }
    /**
     * @param array $toExclude
     */
    public function excludeFromLoop(array $toExclude)
    {
        $this->excluded = $toExclude;
    }
    /**
     * @return \ArrayIterator
     */
    public function getIterator() : \ArrayIterator
    {
        $parameters = array();
        if (!empty($this->excluded)) {
            foreach ($this->parameters as $parameter) {
                if (in_array($parameter->getName(), $this->excluded) === false) {
                    $parameters[] = $parameter;
                }
            }

            return new \ArrayIterator($parameters);
        }

        return new \ArrayIterator($this->parameters);
    }
}