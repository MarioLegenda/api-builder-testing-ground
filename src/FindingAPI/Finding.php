<?php

namespace FindingAPI;

use FindingAPI\Core\Event\ItemFilterEvent;
use FindingAPI\Core\Information\OperationName;
use FindingAPI\Core\Options\Options;
use FindingAPI\Core\Request\Method\FindItemsByKeywordsRequest;
use FindingAPI\Core\Request\RequestValidator;
use FindingAPI\Core\Request\Request;
use FindingAPI\Processor\Factory\ProcessorFactory;
use FindingAPI\Processor\RequestProducer;
use FindingAPI\Core\Response\ResponseInterface;
use FindingAPI\Core\Response\ResponseProxy;

use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Psr7\Response as GuzzleResponse;
use GuzzleHttp\Exception\ConnectException;
use FindingAPI\Core\Exception\ConnectException as FindingConnectException;
use Symfony\Component\EventDispatcher\EventDispatcher;
use FindingAPI\Core\Response\FakeGuzzleResponse;

class Finding implements EbayApiInterface
{
    /**
     * @var Options[] $options
     */
    private $options;
    /**
     * @var GuzzleResponse $guzzleResponse
     */
    private $guzzleResponse;
    /**
     * @var mixed $responseToParse
     */
    private $responseToParse;
    /**
     * @var Request $configuration
     */
    private $request;
    /**
     * @var ResponseInterface $response
     */
    private $response;
    /**
     * @var EventDispatcher
     */
    private $eventDispatcher;
    /**
     * @var string $processed
     */
    private $processed;
    /**
     * Finding constructor.
     * @param Request $request
     * @param Options $options
     * @param EventDispatcher $eventDispatcher
     */
    public function __construct(Request $request, Options $options, EventDispatcher $eventDispatcher)
    {
        $this->request = $request;
        $this->options = $options;
        $this->eventDispatcher = $eventDispatcher;
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
     * @return string
     */
    public function getProcessedRequestString()
    {
        return $this->processed;
    }
    /**
     * @return EbayApiInterface
     * @throws FindingConnectException
     */
    public function send() : EbayApiInterface
    {
        $this->dispatchListeners();

        $this->processRequest();

        $this->sendRequest();

        return $this;
    }
    /**
     * @param string $inlineResponse
     * @return ResponseInterface
     */
    public function getResponse(string $inlineResponse = null) : ResponseInterface
    {
        if (is_string($inlineResponse)) {
            return new ResponseProxy(
                $inlineResponse,
                new FakeGuzzleResponse($inlineResponse),
                $this->request->getRequestParameters()->getParameter('RESPONSE-DATA-FORMAT')->getValue()
            );
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

        $this->response = new ResponseProxy(
            $this->responseToParse,
            $this->guzzleResponse,
            $this->request->getRequestParameters()->getParameter('RESPONSE-DATA-FORMAT')->getValue()
        );

        unset($this->responseToParse);
        unset($this->guzzleResponse);

        return $this->response;
    }
    /**
     * @return Request
     */
    public function getRequest() : Request
    {
        return $this->request;
    }
    /**
     * @param string $operationName
     * @return Request
     */
    public function createMethodCall(string $operationName) : Request
    {
        $this->request = $this->createMethod($operationName);

        return $this->request;
    }

    private function dispatchListeners()
    {
        if ($this->options->getOption(Options::GLOBAL_ITEM_FILTERS)->getValue() === true) {
            $this->eventDispatcher->dispatch('item_filter.pre_validate', new ItemFilterEvent($this->request->getItemFilterStorage()));
        }

        if ($this->options->getOption(Options::INDIVIDUAL_ITEM_FILTERS)->getValue() === true) {
            (new RequestValidator($this->request))->validate();
        }

        if ($this->options->getOption(Options::GLOBAL_ITEM_FILTERS)->getValue() === true) {
            $this->eventDispatcher->dispatch('item_filter.post_validate', new ItemFilterEvent($this->request->getItemFilterStorage()));
        }
    }

    private function processRequest()
    {
        $processors = (new ProcessorFactory($this->request))->createProcessors();

        $this->processed = (new RequestProducer($processors))->produce()->getFinalProduct();

        if ($this->options->getOption(Options::OFFLINE_MODE)->getValue() === true) {
            return $this;
        }
    }

    private function sendRequest()
    {
        try {
            $this->guzzleResponse = $this->request->sendRequest($this->processed);
        } catch (ConnectException $e) {
            throw new FindingConnectException('GuzzleHttp threw a ConnectException. You are probably not connected to the internet. Exception message is '.$e->getMessage());
        } catch (ServerException $e) {
            throw new FindingConnectException('GuzzleHttp threw an exception with message: \''.$e->getMessage().'\'');
        }

        $this->responseToParse = (string) $this->guzzleResponse->getBody();
    }

    private function createMethod(string $operationName)
    {
        switch ($operationName) {
            case OperationName::FIND_ITEMS_BY_KEYWORDS:
                return new FindItemsByKeywordsRequest($this->request);

                break;
        }
    }
}