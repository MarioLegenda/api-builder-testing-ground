<?php

namespace SDKBuilder;

use SDKBuilder\Exception\SDKBuilderException;
use SDKBuilder\Request\Request;
use SDKBuilder\Request\RequestParameters;
use SDKBuilder\Request\Method\MethodParameters;

abstract class AbstractApiFactory
{
    /**
     * @var Request $request
     */
    protected $request;
    /**
     * @var MethodParameters $methodParameters
     */
    protected $methodParameters;
    /**
     * @param string $apiKey
     * @param array $config
     * @throws SDKBuilderException
     */
    protected function createDependencies(string $apiKey, array $config)
    {
        if (!array_key_exists('sdk', $config)) {
            throw new SDKBuilderException('\'sdk\' config key not found in configuration');
        }

        if (!array_key_exists($apiKey, $config['sdk'])) {
            throw new SDKBuilderException('\''.$apiKey.'\' not found under \'sdk\' configuration key');
        }

        $this->request = new Request(
            new RequestParameters($config['sdk'][$apiKey]['global_parameters']),
            new RequestParameters($config['sdk'][$apiKey]['special_parameters'])
        );

        $this->methodParameters = new MethodParameters($config['sdk'][$apiKey]['methods']);
    }
}