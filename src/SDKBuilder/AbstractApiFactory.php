<?php

namespace SDKBuilder;

use SDKBuilder\Exception\SDKBuilderException;
use SDKBuilder\Request\AbstractRequest;
use SDKBuilder\Request\AbstractValidator;
use SDKBuilder\Request\BasicRequestValidator;
use SDKBuilder\Request\Request;
use SDKBuilder\Request\RequestParameters;
use SDKBuilder\Request\Method\MethodParameters;
use SDKBuilder\Request\ValidatorsProcessor;
use SDKBuilder\SDK\SDKInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use SDKBuilder\Processor\Factory\ProcessorFactory;

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
     * @var EventDispatcher $eventDispatcher
     */
    protected $eventDispatcher;
    /**
     * @param string $apiKey
     * @param array $config
     * @throws SDKBuilderException
     * @return SDKInterface
     */
    protected function createApi(string $apiKey, array $config) : SDKInterface
    {
        $this->validateSDK($apiKey, $config);

        $apiConfig = $config['sdk'][$apiKey];
        $requestClass = 'SDKBuilder\\Request\\Request';
        $apiClass = $apiConfig['api_class'];

        if (array_key_exists('request_class', $apiConfig)) {
            $requestClass = $apiConfig['request_class'];

            if (!class_exists($requestClass)) {
                throw new SDKBuilderException('Invalid request class. Class '.$requestClass.' does not exist');
            }
        }

        if (!class_exists($apiClass)) {
            throw new SDKBuilderException('Api class '.$apiClass.' does not exist');
        }

        $this->request = $this->createRequest($requestClass, $apiKey, $config);

        $this->methodParameters = $this->createMethodParameters($apiKey, $config);

        $this->eventDispatcher = new EventDispatcher();

        $processorFactory = new ProcessorFactory($this->request);

        $validatorProcessor = new ValidatorsProcessor();

        $validatorProcessor->addValidator(new BasicRequestValidator($this->request));

        if (array_key_exists('request_validators', $apiConfig)) {
            $validators = $apiConfig['request_validators'];

            foreach ($validators as $validator) {
                if (!class_exists($validator)) {
                    throw new SDKBuilderException('Invalid validator. Validator '.$validator.' does not exist');
                }

                $v = new $validator($this->request);

                if (!$v instanceof AbstractValidator) {
                    throw new SDKBuilderException('Invalid validator. Validator should extend '.AbstractValidator::class);
                }

                $validatorProcessor->addValidator($v);
            }
        }

        return new $apiClass(
            $this->request,
            $processorFactory,
            $this->eventDispatcher,
            $this->methodParameters,
            $validatorProcessor
        );
    }

    private function validateSDK(string $apiKey, array $config) : void
    {
        if (!array_key_exists('sdk', $config)) {
            throw new SDKBuilderException('\'sdk\' config key not found in configuration');
        }

        if (!array_key_exists($apiKey, $config['sdk'])) {
            throw new SDKBuilderException('\''.$apiKey.'\' not found under \'sdk\' configuration key');
        }
    }

    private function createRequest(string $requestClass, string $apiKey, array $config) : AbstractRequest
    {
        $request = new $requestClass(
            new RequestParameters($config['sdk'][$apiKey]['global_parameters']),
            new RequestParameters($config['sdk'][$apiKey]['special_parameters'])
        );

        return $request;
    }

    private function createMethodParameters(string $apiKey, array $config) : ?MethodParameters
    {
        if (array_key_exists('methods', $config['sdk'][$apiKey])) {
            return new MethodParameters($config['sdk'][$apiKey]['methods']);
        }

        return null;
    }
}