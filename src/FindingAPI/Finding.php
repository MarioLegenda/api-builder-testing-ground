<?php

namespace FindingAPI;

use FindingAPI\Core\Event\AddProcessorEvent;
use SDKBuilder\AbstractSDK;
use FindingAPI\Core\Event\ItemFilterEvent;
use SDKBuilder\Exception\MethodParametersException;
use FindingAPI\Core\Options\Options;
use FindingAPI\Core\Request\RequestValidator;
use FindingAPI\Core\Request\Request;
use FindingAPI\Core\Response\ResponseInterface;
use FindingAPI\Core\Response\ResponseProxy;
use SDKBuilder\Processor\Factory\ProcessorFactory;
use SDKBuilder\Request\Method\MethodParameters;
use SDKBuilder\Request\Method\Method;

use FindingAPI\Core\Exception\ConnectException as FindingConnectException;
use SDKBuilder\SDK\SDKInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use FindingAPI\Core\Response\FakeGuzzleResponse;

class Finding extends AbstractSDK
{
    /**
     * @var Options[] $options
     */
    private $options;
    /**
     * @var ResponseInterface $response
     */
    private $response;
    /**
     * @var array $errors
     */
    private $errors = array();
    /**
     * @param Options $options
     * @return Finding
     */
    public function addOptions(Options $options) : Finding
    {
        $this->options = $options;

        return $this;
    }
    /**
     * @param string $option
     * @param $value
     * @return Finding
     */
    public function setOption(string $option, $value) : Finding 
    {
        if ($this->options->hasOption($option)) {
            $this->options->modifyOption($option, $value);
        }
        
        return $this;
    }
    /**
     * @return Finding
     * @throws FindingConnectException
     */
    public function send() : SDKInterface
    {
        if ($this->options->getOption(Options::INDIVIDUAL_ITEM_FILTERS)->getValue() === true) {
            $requestValidator = new RequestValidator($this->request);

            $requestValidator->validate();

            $this->errors = $requestValidator->getErrors();
        }

        $this->dispatchListeners();

        parent::send();

        return $this;
    }
    /**
     * @param string $inlineResponse
     * @return ResponseInterface
     */
    public function getResponse(string $inlineResponse = null) : ResponseInterface
    {
        if (is_string($inlineResponse)) {
            $response = new ResponseProxy(
                $inlineResponse,
                new FakeGuzzleResponse($inlineResponse),
                $this->request->getRequestParameters()->getParameter('RESPONSE-DATA-FORMAT')->getValue()
            );

            return $response;
        }

        if (class_exists('EbayOfflineMode\EbayOfflineMode')) {
            if ($this->options->getOption(Options::OFFLINE_MODE)->getValue() === true) {
                $offlineMode = new \EbayOfflineMode\EbayOfflineMode($this);

                return $offlineMode->getResponse();
            }
        }

        if ($this->response instanceof ResponseInterface) {
            return $this->response;
        }

        $response = new ResponseProxy(
            $this->responseToParse,
            $this->guzzleResponse,
            $this->request->getGlobalParameters()->getParameter('response_data_format')->getValue()
        );

        unset($this->responseToParse);
        unset($this->guzzleResponse);

        $this->response = $response;

        return $this->response;
    }

    public function __call($methodName, $arguments) : Request
    {
        $method = $this->methodParameters->getMethod($methodName);

        $validMethodsParameter = $this->getRequest()->getGlobalParameters()->getParameter($this->methodParameters->getValidMethodsParameter());

        $method->validate($validMethodsParameter);

        $this->request = $this->createMethod($method);

        return $this->request;
    }

    private function dispatchListeners()
    {
        if ($this->options->getOption(Options::GLOBAL_ITEM_FILTERS)->getValue() === true) {
            $this->eventDispatcher->dispatch('item_filter.pre_validate', new ItemFilterEvent($this->request->getItemFilterStorage()));
        }

        if ($this->options->getOption(Options::GLOBAL_ITEM_FILTERS)->getValue() === true) {
            $this->eventDispatcher->dispatch('item_filter.post_validate', new ItemFilterEvent($this->request->getItemFilterStorage()));
        }

        $this->eventDispatcher->dispatch('finding.add_processor', new AddProcessorEvent($this->processorFactory, $this->request));
    }

    private function createMethod(Method $method) : Request
    {
        $instanceString = $method->getInstanceObjectString();

        $object = new $instanceString($this->request->getGlobalParameters(), $this->request->getSpecialParameters());

        if (!$object instanceof Request) {
            throw new MethodParametersException(get_class($object).' has to extend '.Request::class);
        }

        $objectMethods = $method->getMethods();

        $specialParameters = $this->request->getSpecialParameters();

        foreach ($objectMethods as $objectMethod) {
            if (!$specialParameters->hasParameter($objectMethod)) {
                throw new MethodParametersException('Cannot create request method because parameter '.$objectMethod.' does not exist for request method '.$method->getName());
            }

            $parameter = $this->request->getSpecialParameters()->getParameter($objectMethod);
            $parameter->enable();

            $set = 'set'.preg_replace('#\s#', '', ucwords(preg_replace('#_#', ' ', $parameter->getName())));
            $add = 'add'.preg_replace('#\s#', '', ucwords(preg_replace('#_#', ' ', $parameter->getName())));
            $enable = 'enable'.preg_replace('#\s#', '', ucwords(preg_replace('#_#', ' ', $parameter->getName())));
            $disable = 'disable'.preg_replace('#\s#', '', ucwords(preg_replace('#_#', ' ', $parameter->getName())));

            $possibleMethods = array(
                $set,
                $add,
                $enable,
                $disable,
                $objectMethod,
            );

            $classMethods = get_class_methods($object);

            $methodValidated = false;
            foreach ($possibleMethods as $possibleMethod) {
                if (in_array($possibleMethod, $classMethods)) {
                    $methodValidated = true;

                    break;
                }
            }

            if ($methodValidated === false) {
                throw new MethodParametersException('Possible methods '.implode(', ', $possibleMethods).' for object '.$instanceString.' not found');
            }
        }

        return $object;
    }
    /**
     * @return bool
     */
    public function hasErrors() : bool
    {
        return !empty($this->errors);
    }
    /**
     * @return array
     */
    public function getErrors() : array
    {
        return $this->errors;
    }
}