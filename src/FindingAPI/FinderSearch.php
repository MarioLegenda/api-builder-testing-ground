<?php

namespace FindingAPI;

use FindingAPI\Core\ItemFilter\ItemFilterValidator;
use FindingAPI\Core\Request;
use FindingAPI\Processor\Factory\ProcessorFactory;
use FindingAPI\Processor\RequestProducer;

class FinderSearch
{
    /**
     * @var Request $configuration
     */
    private $request;
    /**
     * @var static FinderSearch $instance
     */
    private static $instance;
    /**
     * @var string $processed
     */
    private $processed;

    /**
     * @param Request|null $configuration
     * @return FinderSearch
     */
    public static function getInstance(Request $request) : FinderSearch
    {
        if (self::$instance instanceof self) {
            return self::$instance;
        }

        self::$instance = new FinderSearch($request);

        return self::$instance;
    }

    /**
     * FinderSearch constructor.
     * @param Request $configuration
     */
    private function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return string
     */
    public function getProcessed()
    {
        return $this->processed;
    }
    /**
     * @return FinderSearch
     * @throws Core\Exception\FindingApiException
     */
    public function send() : FinderSearch
    {
        (new ItemFilterValidator($this->request->getItemFilterStorage()))->validate();

        $processors = (new ProcessorFactory($this->request))->createProcessors();

        $this->processed = (new RequestProducer($processors))->produce()->getFinalProduct();

        $this->request->sendRequest($this->processed);

        return $this;
    }
}