<?php

namespace SDKBuilder;

use SDKBuilder\Event\AddProcessorEvent;
use SDKBuilder\Event\PostProcessRequestEvent;
use SDKBuilder\Event\PostSendRequestEvent;
use SDKBuilder\Event\PreProcessRequestEvent;
use SDKBuilder\Event\RequestEvent;
use SDKBuilder\Event\SDKEvent;
use SDKBuilder\Event\SendRequestEvent;
use SDKBuilder\Exception\SDKException;
use SDKBuilder\Processor\Factory\ProcessorFactory;
use SDKBuilder\Processor\Get\GetRequestParametersProcessor;
use SDKBuilder\Request\Method\MethodParameters;
use SDKBuilder\Request\Method\Method;
use SDKBuilder\Request\Parameter;
use SDKBuilder\Request\RequestInterface;
use SDKBuilder\Request\ValidatorsProcessor;
use SDKBuilder\SDK\SDKInterface;

use SDKBuilder\Processor\RequestProducer;

use Symfony\Component\EventDispatcher\EventDispatcher;
use SDKBuilder\Exception\MethodParametersException;

abstract class AbstractSDK implements SDKInterface
{
    /**
     * @var string $processed
     */
    private $processed;
    /**
     * @var bool $isCompiled
     */
    private $isCompiled = false;
    /**
     * @var RequestInterface $request
     */
    private $request;
    /**
     * @var MethodParameters $methodParameters
     */
    private $methodParameters;
    /**
     * @var ProcessorFactory $processorFactory
     */
    private $processorFactory;
    /**
     * @var EventDispatcher
     */
    private $eventDispatcher;
    /**
     * @var mixed $responseClient
     */
    protected $responseClient;
    /**
     * @var ValidatorsProcessor
     */
    private $validatorsProcessor;
    /**
     * @var string $responseToParse
     */
    private $responseToParse;
    /**
     * @var SDKOfflineMode\SDKOfflineMode
     */
    private $offlineMode;
    /**
     * @var bool $offlineModeSwitch
     */
    private $offlineModeSwitch = false;
    /**
     * AbstractSDK constructor.
     * @param RequestInterface $request
     * @param MethodParameters $methodParameters
     * @param ProcessorFactory $processorFactory
     * @param EventDispatcher $eventDispatcher
     * @param ValidatorsProcessor $validatorsProcessor
     */
    public function __construct(
        RequestInterface $request,
        ProcessorFactory $processorFactory,
        EventDispatcher $eventDispatcher,
        ?MethodParameters $methodParameters,
        ValidatorsProcessor $validatorsProcessor)
    {
        $this->request = $request;
        $this->methodParameters = $methodParameters;
        $this->processorFactory = $processorFactory;
        $this->eventDispatcher = $eventDispatcher;
        $this->validatorsProcessor = $validatorsProcessor;
    }
    /**
     * @param bool $switch
     * @return SDKInterface
     */
    public function switchOfflineMode(bool $switch) : SDKInterface
    {
        $this->offlineModeSwitch = $switch;

        return $this;
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
    public function compile() : SDKInterface
    {
        if ($this->getRequest()->getMethod() === 'get') {
            $this->processorFactory->registerProcessor($this->getRequest()->getMethod(), GetRequestParametersProcessor::class);
        }

        if ($this->eventDispatcher->hasListeners('sdk.add_processors')) {
            $this->eventDispatcher->dispatch('sdk.add_processors', new AddProcessorEvent(
                $this->getProcessorFactory(),
                $this->getRequest()
            ));
        }

        if ($this->eventDispatcher->hasListeners(SDKEvent::PRE_PROCESS_REQUEST_EVENT)) {
            $this->eventDispatcher->dispatch(SDKEvent::PRE_PROCESS_REQUEST_EVENT, new PreProcessRequestEvent($this->getRequest()));
        }

        $this->processRequest();

        if ($this->eventDispatcher->hasListeners(SDKEvent::POST_PROCESS_REQUEST_EVENT)) {
            $this->eventDispatcher->dispatch(SDKEvent::POST_PROCESS_REQUEST_EVENT, new PostProcessRequestEvent($this->getRequest()));
        }

        if ($this->offlineModeSwitch === true) {
            if (!$this->offlineMode instanceof \SDKOfflineMode\SDKOfflineMode and class_exists('SDKOfflineMode\\SDKOfflineMode')) {
                if ($this->getRequest()->getMethod() !== 'get') {
                    throw new SDKException('If this is your development environment and you are using SDKOfflineMode tool, you can only use it with \'get\' requests. If you are on a production server, it is advised to turn SDKOfflineMode of with AbstractSDK::switchOfflineMode(false)');
                }

                $this->offlineMode = new \SDKOfflineMode\SDKOfflineMode($this);
            }
        }

        $this->isCompiled = true;

        return $this;
    }
    /**
     * @return SDKInterface
     */
    public function send() : SDKInterface
    {
        $this->validatorsProcessor->validate();

        if ($this->offlineModeSwitch === true) {
            if ($this->offlineMode instanceof \SDKOfflineMode\SDKOfflineMode) {
                if ($this->offlineMode->isResponseStored($this->getProcessedRequestString())) {
                    return $this;
                }
            }
        }

        $this->sendRequest();

        return $this;
    }
    /**
     * @return RequestInterface
     */
    public function getRequest() : RequestInterface
    {
        return $this->request;
    }
    /**
     * @param RequestInterface $request
     * @return SDKInterface
     */
    public function setRequest(RequestInterface $request) : SDKInterface
    {
        $this->request = $request;

        return $this;
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
     * @return mixed
     * @throws SDKException
     */
    public final function getResponseBody()
    {
        return $this->responseToParse;
    }
    /**
     * @param $methodName
     * @param $arguments
     * @return RequestInterface
     */
    public function __call($methodName, $arguments) : RequestInterface
    {
        $method = $this->methodParameters->getMethod($methodName);

        $validMethodsParameter = $this->getRequest()->getGlobalParameters()->getParameter($this->methodParameters->getValidMethodsParameter());

        $method->validate($validMethodsParameter);

        $this->setRequest($this->createMethod($method));

        return $this->getRequest();
    }
    /**
     * @return ProcessorFactory
     */
    public function getProcessorFactory() : ProcessorFactory
    {
        return $this->processorFactory;
    }
    /**
     * @void
     */
    public function restoreDefaults() : void
    {
        $objectProperties = get_object_vars($this);

        foreach ($objectProperties as $objectProperty) {
            if ($objectProperty instanceof RestoreDefaultsInterface) {
                $objectProperty->restoreDefaults();
            }
        }

        $this->offlineMode = null;
        $this->isCompiled = false;
    }

    private function processRequest()
    {
        $processors = $this->processorFactory->createProcessors($this->getRequest());

        $this->processed = (new RequestProducer($processors))->produce()->getFinalProduct();
    }

    private function sendRequest() : void
    {
        if (!$this->isCompiled) {
            throw new SDKException('Api is not compiled. If you extended the AbstractSDK::compile() method, you need to call parent::compile() in your extended method');
        }

        if ($this->eventDispatcher->hasListeners(SDKEvent::PRE_SEND_REQUEST_EVENT)) {
            $this->eventDispatcher->dispatch(SDKEvent::PRE_SEND_REQUEST_EVENT, new RequestEvent($this->getRequest()));
        }

        try {
            if ($this->eventDispatcher->hasListeners(SDKEvent::SEND_REQUEST_EVENT)) {
                $this->eventDispatcher->dispatch(new SendRequestEvent($this, $this->getRequest()));
            } else {
                $this->responseToParse = $this->getRequest()->sendRequest($this->processed)->getBody();
            }
        } catch (\Exception $e) {
            echo 'Generic exception caught with message: \''.$e->getMessage().'\'';
            die();
        }

        if ($this->eventDispatcher->hasListeners(SDKEvent::POST_SEND_REQUEST_EVENT)) {
            $this->eventDispatcher->dispatch(SDKEvent::POST_SEND_REQUEST_EVENT, new PostSendRequestEvent($this, $this->getRequest()));
        }
    }


    private function createMethod(Method $method) : RequestInterface
    {
        $instanceString = $method->getInstanceObjectString();

        $object = new $instanceString($this->getRequest()->getGlobalParameters(), $this->getRequest()->getSpecialParameters());

        if (!$object instanceof RequestInterface) {
            throw new MethodParametersException(get_class($object).' has to extend '.RequestInterface::class);
        }

        $objectMethods = $method->getMethods();

        $specialParameters = $this->getRequest()->getSpecialParameters();

        foreach ($objectMethods as $objectMethod) {
            if (!$specialParameters->hasParameter($objectMethod)) {
                throw new MethodParametersException('Cannot create request method because parameter '.$objectMethod.' does not exist for request method '.$method->getName());
            }

            $parameter = $this->getRequest()->getSpecialParameters()->getParameter($objectMethod);
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