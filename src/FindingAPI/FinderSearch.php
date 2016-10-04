<?php

namespace FindingAPI;

use FindingAPI\Core\Exception\FindingApiException;
use FindingAPI\Core\ItemFilter\ItemFilterStorage;
use FindingAPI\Core\ItemFilter\ItemFilterValidator;
use FindingAPI\Core\Options;
use FindingAPI\Definition\DefinitionFactory;
use FindingAPI\Definition\DefinitionValidator;
use FindingAPI\Definition\Exception\DefinitionException;
use FindingAPI\Definition\SearchDefinitionInterface;
use FindingAPI\Core\Request;
use FindingAPI\Definition\Type\DefinitionTypeFactory;
use FindingAPI\Processor\ProcessorFactory;

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
        
        

        $this->processed = $processed;

        $this->request->sendRequest($processed);

        return $this;
    }
}