<?php

namespace FindingAPI;

use FindingAPI\Core\Event\ItemFilterEvent;
use FindingAPI\Core\Listener\PostValidateItemFilters;
use FindingAPI\Core\Listener\PreValidateItemFilters;
use FindingAPI\Core\Options\Option;
use FindingAPI\Core\Options\Options;
use FindingAPI\Core\Request\RequestValidator;
use FindingAPI\Core\Request\Request as FindingRequest;
use FindingAPI\Core\Request\Request;
use FindingAPI\Core\Response;
use FindingAPI\Processor\Factory\ProcessorFactory;
use FindingAPI\Processor\RequestProducer;
use FindingAPI\Core\Response\ResponseInterface;
use FindingAPI\Core\Response\ResponseProxy;

use GuzzleHttp\Psr7\Response as GuzzleResponse;
use GuzzleHttp\Exception\ConnectException;
use FindingAPI\Core\Exception\ConnectException as FindingConnectException;
use Symfony\Component\EventDispatcher\EventDispatcher;

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
     * @var array $validation
     */
    private $validation = array(
        'individual-item-filters' => true,
        'global-item-filters' => true,
    );
    /**
     * @var static FinderSearch $instance
     */
    private static $instance;
    /**
     * @param FindingRequest|null $configuration
     * @return $this
     */
    public static function getInstance(FindingRequest $request) : Finding
    {
        if (self::$instance instanceof self) {
            return self::$instance;
        }

        self::$instance = new Finding($request);

        return self::$instance;
    }
    /**
     * FinderSearch constructor.
     * @param FindingRequest $configuration
     */
    private function __construct(FindingRequest $request)
    {
        $this->request = $request;

        $options = new Options();
        $options->addOption(new Option(Options::GLOBAL_ITEM_FILTERS, true));
        $options->addOption(new Option(Options::INDIVIDUAL_ITEM_FILTERS, true));

        $this->options = $options;

        $this->eventDispatcher = new EventDispatcher();

        $this->eventDispatcher->addListener('item_filter.pre_validate', array(new PreValidateItemFilters(), 'onPreValidate'));
        $this->eventDispatcher->addListener('item_filter.post_validate', array(new PostValidateItemFilters(), 'onPostValidate'));

        if ($this->options->getOption(Options::GLOBAL_ITEM_FILTERS)->getValue() === true) {
            $this->eventDispatcher->dispatch('item_filter.pre_validate', new ItemFilterEvent($this->request->getItemFilterStorage()));
        }

        if ($this->options->getOption(Options::INDIVIDUAL_ITEM_FILTERS)->getValue() === true) {
            (new RequestValidator($this->request))->validate();
        }

        if ($this->options->getOption(Options::GLOBAL_ITEM_FILTERS)->getValue() === true) {
            $this->eventDispatcher->dispatch('item_filter.post_validate', new ItemFilterEvent($this->request->getItemFilterStorage()));
        }

        $processors = (new ProcessorFactory($this->request))->createProcessors();

        $this->processed = (new RequestProducer($processors))->produce()->getFinalProduct();
    }

    /**
     * @return Request
     */
    public function getRequest() : Request
    {
        return $this->request;
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
    public function getProcessed()
    {
        return $this->processed;
    }
    /**
     * @return $this
     * @throws Core\Exception\FindingApiException
     */
    public function send() : Finding
    {
        try {
            $this->guzzleResponse = $this->request->sendRequest($this->processed);
        } catch (ConnectException $e) {
            throw new FindingConnectException('GuzzleHttp threw a ConnectException. You are probably not connected to the internet. Exception message is '.$e->getMessage());
        }

        $this->responseToParse = (string) $this->guzzleResponse->getBody();

        return $this;
    }
    /**
     * @return FindingRequest
     */
    public function createRequest() : FindingRequest
    {
        return new FindingRequest();
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
                null,
                $this->request->getRequestParameters()->getParameter('RESPONSE-DATA-FORMAT')->getValue()
            );
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
}