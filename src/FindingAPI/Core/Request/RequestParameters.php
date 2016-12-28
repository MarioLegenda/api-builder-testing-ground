<?php

namespace FindingAPI\Core\Request;

use FindingAPI\Core\Exception\{
    DeprecatedException, RequestException, RequestParametersException
};

class RequestParameters implements \IteratorAggregate, \ArrayAccess
{
    /**
     * const string
     */
    const REQUEST_METHOD_POST = 'post';
    /**
     * const string
     */
    const REQUEST_METHOD_GET = 'get';
    /**
     * const string
     */
    const RESPONSE_DATA_FORMAT_XML = 'xml';
    /**
     * const string
     */
    const RESPONSE_DATA_FORMAT_JSON = 'json';
    /**
     * @var array $parameters
     */
    private $parameters;
    /**
     * @var array $excluded
     */
    private $excluded = array();
    /**
     * @var null $errors
     */
    private $errors = array();
    /**
     * RequestParameters constructor.
     * @param array|null $parameters
     */
    public function __construct(array $parameters)
    {
        foreach ($parameters as $parameterName => $parameter) {
            $this->parameters[] = new Parameter($parameterName, $parameter);
        }
    }
    /**
     * @param Parameter $parameter
     */
    public function addParameter(Parameter $parameter)
    {
        $parameter->validateParameter();

        if ($this->hasParameter($parameter->getName())) {
            $this->removeParameter($parameter->getName());
        }

        $this->parameters[] = $parameter;
    }
    /**
     * @param string $name
     * @param string $value
     * @return RequestParameters
     * @throws RequestException
     */
    public function setParameter(string $name, string $value) : RequestParameters
    {
        if (!$this->hasParameter($name)) {
            throw new RequestException('Unknown request parameter '.$name.'. If you which to add a new parameter, use Request::__construct(array $parameters) and add the new parameters there. The new parameter will be appended on the existing ones');
        }

        $this->getParameter($name)->setValue($value);

        return $this;
    }
    /**
     * @param string $name
     * @return Parameter
     * @throws RequestException
     */
    public function getParameter(string $name) : Parameter
    {
        if (!$this->hasParameter($name)) {
            throw new RequestException('Unknown parameter '.$name);
        }

        foreach ($this->parameters as $parameter) {
            if ($parameter->getName() === $name or $parameter->getRepresentation() === $name) {
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
            if ($parameter->getName() === $name or $parameter->getRepresentation() === $name) {
                return true;
            }
        }

        return false;
    }
    /**
     * @param string $name
     * @return bool
     */
    public function removeParameter(string $name) : bool
    {
        foreach ($this->parameters as $key => $parameter) {
            if ($parameter->getName() === $name or $parameter->getRepresentation() === $name) {
                unset($this->parameters[$key]);

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
            if ($parameter->shouldThrowExceptionIfDeprecated()) {
                throw new DeprecatedException('Request parameter '.$name.' seems to be deprecated. If you which to ignore it, catch DeprecatedException');
            }
        }

        if (!$parameter->isValid($value)) {
            throw new RequestException('Parameter '.$name.' exists but is not valid. This means that ebay supports exact list of values for this parameter. Valid values for this parameter are '.implode(', ', $parameter->getValid()));
        }

        return true;
    }
    /**
     * @return RequestParameters
     */
    public function validate() : RequestParameters
    {
        $errorMessages = array();
        foreach ($this->parameters as $parameter) {
            $possibleError = $parameter->validateParameter();

            if (is_array($possibleError)) {
                $errorMessages[$parameter->getRepresentation()] = $parameter->validateParameter();
            }
        }

        if (!empty($errorMessages)) {
            $this->errors = $errorMessages;
        }

        return $this;
    }
    /**
     * @return array
     */
    public function getErrors() : array
    {
        return $this->errors;
    }
    /**
     * @void
     */
    public function restoreDefaults()
    {
        foreach ($this->parameters as $parameter) {
            if ($parameter->getType()->isOptional()) {
                $parameter->setValue(null);
                $parameter->disable();
            }
        }
    }
    /**
     * @param array $toExclude
     */
    public function excludeFromLoopByKey(array $toExclude)
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
    /**
     * @param mixed $offset
     * @param mixed $value
     * @throws RequestParametersException
     */
    public function offsetSet($offset, $value)
    {
        throw new RequestParametersException('Setting parameters with ArrayAccess interface is forbidden');
    }
    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->parameters[$offset]);
    }
    /**
     * @param mixed $offset
     * @throws RequestParametersException
     */
    public function offsetUnset($offset)
    {
        throw new RequestParametersException('Unsetting parameters with ArrayAccess interface is forbidden');
    }
    /**
     * @param mixed $offset
     * @return mixed|null
     */
    public function offsetGet($offset)
    {
        return isset($this->parameters[$offset]) ? $this->parameters[$offset] : null;
    }

}