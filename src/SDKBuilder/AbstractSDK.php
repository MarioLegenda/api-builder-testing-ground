<?php

namespace SDKBuilder;

use SDKBuilder\Processor\Factory\ProcessorFactory;
use SDKBuilder\Processor\Get\GetRequestParametersProcessor;
use SDKBuilder\Request\AbstractRequest;
use SDKBuilder\Request\Method\MethodParameters;
use SDKBuilder\Request\Method\Method;
use SDKBuilder\Request\Parameter;
use SDKBuilder\Request\ValidatorsProcessor;
use SDKBuilder\SDK\SDKInterface;

use GuzzleHttp\Exception\ServerException;
use FindingAPI\Core\Exception\ConnectException;
use SDKBuilder\Common\Logger;

use GuzzleHttp\Psr7\Response as GuzzleResponse;
use SDKBuilder\Processor\RequestProducer;

use Symfony\Component\EventDispatcher\EventDispatcher;
use SDKBuilder\Exception\MethodParametersException;

abstract class AbstractSDK implements SDKInterface
{
    /**
     * @var string $responseToParse
     */
    protected $responseToParse;
    /**
     * @var string $processed
     */
    protected $processed;
    /**
     * @var GuzzleResponse $guzzleResponse
     */
    protected $guzzleResponse;
    /**
     * @var AbstractRequest $request
     */
    protected $request;
    /**
     * @var MethodParameters $methodParameters
     */
    protected $methodParameters;
    /**
     * @var ProcessorFactory $processorFactory
     */
    protected $processorFactory;
    /**
     * @var EventDispatcher
     */
    protected $eventDispatcher;
    /**
     * @var ValidatorsProcessor
     */
    protected $validatorsProcessor;
    /**
     * AbstractSDK constructor.
     * @param AbstractRequest $request
     * @param MethodParameters $methodParameters
     * @param ProcessorFactory $processorFactory
     * @param EventDispatcher $eventDispatcher
     * @param ValidatorsProcessor $validatorsProcessor
     */
    public function __construct(AbstractRequest $request, ProcessorFactory $processorFactory, EventDispatcher $eventDispatcher, ?MethodParameters $methodParameters, ValidatorsProcessor $validatorsProcessor)
    {
        $this->request = $request;
        $this->methodParameters = $methodParameters;
        $this->processorFactory = $processorFactory;
        $this->eventDispatcher = $eventDispatcher;
        $this->validatorsProcessor = $validatorsProcessor;
    }
    /**
     * @param Method $method
     * @return SDKInterface
     */
    public function addMethod(Method $method) : SDKInterface
    {
        $validMethodsParameter = $this->getRequest()->getGlobalParameters()->getParameter($this->methodParameters->getValidMethodsParameter());

        $method->validate($validMethodsParameter);

        $this->methodParameters->addMethod($method);

        return $this;
    }
    /**
     * @param string $parameterType
     * @param Parameter $parameter
     * @return SDKInterface
     */
    public function addParameter(string $parameterType, Parameter $parameter) : SDKInterface
    {
        if ($parameterType === 'global_parameter') {
            $this->getRequest()->getGlobalParameters()->addParameter($parameter);

            return $this;
        }

        if ($parameterType === 'special_parameter') {
            $this->getRequest()->getSpecialParameters()->addParameter($parameter);
        }

        return $this;
    }
    /**
     * @return SDKInterface
     */
    public function send() : SDKInterface
    {
        $this->validatorsProcessor->validate();

        $this->processRequest();

        $this->sendRequest();

        return $this;
    }
    /**
     * @return AbstractRequest
     */
    public function getRequest() : AbstractRequest
    {
        return $this->request;
    }
    /**
     * @return string
     */
    public function getProcessedRequestString() : string
    {
        return $this->processed;
    }
    /**
     * @return bool
     */
    public function hasErrors() : bool
    {
        return $this->validatorsProcessor->hasErrors();
    }
    /**
     * @return array
     */
    public function getErrors() : array
    {
        return $this->validatorsProcessor->getErrors();
    }
    /**
     * @return string
     */
    public function getResponse()
    {
        return $this->responseToParse;
    }
    /**
     * @param $methodName
     * @param $arguments
     * @return AbstractRequest
     */
    public function __call($methodName, $arguments) : AbstractRequest
    {
        $method = $this->methodParameters->getMethod($methodName);

        $validMethodsParameter = $this->getRequest()->getGlobalParameters()->getParameter($this->methodParameters->getValidMethodsParameter());

        $method->validate($validMethodsParameter);

        $this->request = $this->createMethod($method);

        return $this->request;
    }

    private function processRequest()
    {
        $this->processorFactory->registerProcessor($this->getRequest()->getMethod(), GetRequestParametersProcessor::class);

        $processors = $this->processorFactory->createProcessors();

        $this->processed = (new RequestProducer($processors))->produce()->getFinalProduct();
    }

    private function sendRequest() : void
    {
        try {
            $this->guzzleResponse = $this->request->sendRequest($this->processed);
        } catch (ConnectException $e) {
            throw new ConnectException('GuzzleHttp threw a ConnectException. Exception message is '.$e->getMessage());
        } catch (ServerException $e) {
            throw new ConnectException('GuzzleHttp threw an exception with message: \''.$e->getMessage().'\'');
        }

        Logger::log($this->processed);

        $this->responseToParse = (string) $this->guzzleResponse->getBody();
    }


    private function createMethod(Method $method) : AbstractRequest
    {
        $instanceString = $method->getInstanceObjectString();

        $object = new $instanceString($this->request->getGlobalParameters(), $this->request->getSpecialParameters());

        if (!$object instanceof AbstractRequest) {
            throw new MethodParametersException(get_class($object).' has to extend '.AbstractRequest::class);
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
}