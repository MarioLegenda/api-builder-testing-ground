<?php

namespace SDKBuilder;

use SDKBuilder\Processor\Factory\ProcessorFactory;
use SDKBuilder\Processor\Get\GetRequestParametersProcessor;
use SDKBuilder\Request\AbstractRequest;
use SDKBuilder\Request\Method\MethodParameters;
use SDKBuilder\Request\Method\Method;
use SDKBuilder\Request\Parameter;
use SDKBuilder\SDK\SDKInterface;

use GuzzleHttp\Exception\ServerException;
use FindingAPI\Core\Exception\ConnectException;
use SDKBuilder\Common\Logger;

use GuzzleHttp\Psr7\Response as GuzzleResponse;
use SDKBuilder\Processor\RequestProducer;

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
     * AbstractSDK constructor.
     * @param AbstractRequest $request
     * @param MethodParameters $methodParameters
     * @param ProcessorFactory $processorFactory
     */
    public function __construct(AbstractRequest $request, MethodParameters $methodParameters, ProcessorFactory $processorFactory)
    {
        $this->request = $request;
        $this->methodParameters = $methodParameters;
        $this->processorFactory = $processorFactory;
    }
    /**
     * @param Method $method
     * @return AbstractSDK
     */
    public function addMethod(Method $method) : AbstractSDK
    {
        $validMethodsParameter = $this->getRequest()->getGlobalParameters()->getParameter($this->methodParameters->getValidMethodsParameter());

        $method->validate($validMethodsParameter);

        $this->methodParameters->addMethod($method);

        return $this;
    }
    /**
     * @param string $parameterType
     * @param Parameter $parameter
     * @return AbstractSDK
     */
    public function addParameter(string $parameterType, Parameter $parameter) : AbstractSDK
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

    private function processRequest()
    {
        $this->processorFactory->registerProcessor($this->getRequest()->getMethod(), GetRequestParametersProcessor::class);

        $processors = $this->processorFactory->createProcessors();

        $this->processed = (new RequestProducer($processors))->produce()->getFinalProduct();
    }

    private function sendRequest()
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
}