<?php

namespace FindingAPI\Core;

use FindingAPI\Core\Exception\DeprecatedException;
use FindingAPI\Core\Exception\RequestException;

class RequestParameters
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
     * @var array $parameters
     */
    private $parameters = array(
        'method' => array (
            'type' => 'required',
            'value' => null,
        ),
        'ebay_url' => array(
            'type' => 'required',
            'value' => null,
        ),
        'OPERATION-NAME' => array(
            'type' => 'required',
            'value' => null,
            'valid' => array('findItemsByKeywords'),
        ),
        'SERVICE-VERSION' => array(
            'type' => 'required',
            'value' => null,
        ),
        'SECURITY-APPNAME' => array(
            'type' => 'required',
            'value' => null,
        ),
        'RESPONSE-DATA-FORMAT' => array(
            'type' => 'required',
            'value' => null,
            'valid' => array('xml', 'json'),
        ),
    );
    /**
     * RequestParameters constructor.
     * @param array|null $parameters
     */
    public function __construct(array $parameters = null)
    {
        if ($parameters !== null) {
            $this->parameters = $parameters;
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

        $this->parameters[$name]['deprecated'] = true;

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

        unset($this->parameters[$name]['deprecated']);

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

        $options = $this->getParameter($name);

        return array_key_exists('deprecated', $options);
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
            throw new RequestException('Invalid parameter given for '.$name.' with value '.$value.'. Valid parameters are '.implode(', ', $this->parameters[$name]['valid']));
        }

        $this->parameters[$name]['value'] = $value;

        return $this;
    }
    /**
     * @param string $name
     * @param string $value
     * @param string $type
     * @param array $valids
     * @return RequestParameters
     * @throws RequestException
     */
    public function addParameter(string $name, string $value, string $type, array $valids = array()) : RequestParameters
    {
        if ($this->hasParameter($name)) {
            throw new RequestException('Request parameter '.$name.' already exists. If you which to replace it, use RequestParameters::replaceParameter()');
        }

        $options = array(
            'type' => $type,
            'value' => $value,
        );

        if (!empty($valids)) {
            $options['valid'] = $valids;
        }

        $this->parameters[$name] = $options;

        return $this;
    }
    /**
     * @param string $name
     * @param string $value
     * @param string $type
     * @param array $valids
     * @return RequestParameters
     * @throws RequestException
     */
    public function replaceParameter(string $name, string $value, string $type, $valids = array()) : RequestParameters
    {
        if (!$this->hasParameter($name)) {
            throw new RequestException('Request parameter '.$name.' does not exist. If you which to add a parameter, use RequestParameters::addParameter()');
        }

        unset($this->parameters[$name]);

        $this->addParameter($name, $value, $type, $valids);

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

        return $this->parameters[$name];
    }
    /**
     * @param string $name
     * @return bool
     */
    public function hasParameter(string $name) : bool
    {
        return array_key_exists($name, $this->parameters);
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

        if (array_key_exists('deprecated', $parameter)) {
            throw new DeprecatedException('Request parameter '.$name.' seems to be deprecated. If you which to ignore it, catch DeprecatedException');
        }

        if (array_key_exists('valid', $parameter)) {
            if (in_array($value, $parameter['valid']) === false) {
                return false;
            }
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
}