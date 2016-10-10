<?php

namespace FindingAPI;

use FindingAPI\Core\Event\ItemFilterEvent;
use FindingAPI\Core\Listener\PostValidateItemFilters;
use FindingAPI\Core\Listener\PreValidateItemFilters;
use FindingAPI\Core\RequestValidator;
use FindingAPI\Core\Request;
use FindingAPI\Processor\Factory\ProcessorFactory;
use FindingAPI\Processor\RequestProducer;
use Symfony\Component\EventDispatcher\EventDispatcher;

class FinderSearch
{
    /**
     * @var Request $configuration
     */
    private $request;
    /**
     * @var EventDispatcher
     */
    private $eventDispatcher;
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

        $this->eventDispatcher = new EventDispatcher();

        $this->eventDispatcher->addListener('item_filter.pre_validate', array(new PreValidateItemFilters(), 'onPreValidate'));
        $this->eventDispatcher->addListener('item_filter.post_validate', array(new PostValidateItemFilters(), 'onPostValidate'));
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
        $this->eventDispatcher->dispatch('item_filter.pre_validate', new ItemFilterEvent($this->request->getItemFilterStorage()));

        (new RequestValidator($this->request))->validate();

        $this->eventDispatcher->dispatch('item_filter.post_validate', new ItemFilterEvent($this->request->getItemFilterStorage()));

        $processors = (new ProcessorFactory($this->request))->createProcessors();

        $this->processed = (new RequestProducer($processors))->produce()->getFinalProduct();

        $this->request->sendRequest($this->processed);

        return $this;
    }
}