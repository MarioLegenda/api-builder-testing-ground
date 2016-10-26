<?php

namespace FindingAPI;

use FindingAPI\Core\Event\ItemFilterEvent;
use FindingAPI\Core\Exception\FindingApiException;
use FindingAPI\Core\Listener\PostValidateItemFilters;
use FindingAPI\Core\Listener\PreValidateItemFilters;
use FindingAPI\Core\RequestValidator;
use FindingAPI\Core\Request;
use FindingAPI\Core\Response;
use FindingAPI\Processor\Factory\ProcessorFactory;
use FindingAPI\Processor\RequestProducer;

use GuzzleHttp\Psr7\Response as GuzzleResponse;
use GuzzleHttp\Exception\ConnectException;
use FindingAPI\Core\Exception\ConnectException as FindingConnectException;
use Symfony\Component\EventDispatcher\EventDispatcher;

class Finding
{
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
     * @var Response $response
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
     * @param Request|null $configuration
     * @return $this
     */
    public static function getInstance(Request $request) : Finding
    {
        if (self::$instance instanceof self) {
            return self::$instance;
        }

        self::$instance = new Finding($request);

        return self::$instance;
    }
    /**
     * FinderSearch constructor.
     * @param Request $configuration
     */
    private function __construct(Request $request)
    {
        $this->request = $request;

        $this->eventDispatcher = new EventDispatcher();

        $this->eventDispatcher->addListener('item_filter.pre_validate', array(new PreValidateItemFilters(), 'onPreValidate'));
        $this->eventDispatcher->addListener('item_filter.post_validate', array(new PostValidateItemFilters(), 'onPostValidate'));

        $individualItemFilterValidation = $this->validation['individual-item-filters'];
        $globalItemFilterValidation = $this->validation['global-item-filters'];

        if ($globalItemFilterValidation === true) {
            $this->eventDispatcher->dispatch('item_filter.pre_validate', new ItemFilterEvent($this->request->getItemFilterStorage()));
        }

        if ($individualItemFilterValidation === true) {
            (new RequestValidator($this->request))->validate();
        }

        if ($globalItemFilterValidation === true) {
            $this->eventDispatcher->dispatch('item_filter.post_validate', new ItemFilterEvent($this->request->getItemFilterStorage()));
        }

        $processors = (new ProcessorFactory($this->request))->createProcessors();

        $this->processed = (new RequestProducer($processors))->produce()->getFinalProduct();
    }
    /**
     * @param string $validationType
     * @param bool $rule
     * @return $this
     * @throws FindingApiException
     */
    public function setValidationRule(string $validationType, bool $rule) : Finding
    {
        if (!array_key_exists($validationType, $this->validation)) {
            throw new FindingApiException('Unknown validation rule '.$validationType);
        }

        $this->validation[$validationType] = $rule;

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
     * @return Request
     */
    public function createRequest() : Request
    {
        return new Request();
    }
    /**
     * @return Response
     */
    public function getResponse() : Response
    {
        if ($this->response instanceof Response) {
            return $this->response;
        }

        $this->response = new Response($this->responseToParse, $this->guzzleResponse);

        unset($this->responseToParse);
        unset($this->guzzleResponse);

        return $this->response;
    }
}