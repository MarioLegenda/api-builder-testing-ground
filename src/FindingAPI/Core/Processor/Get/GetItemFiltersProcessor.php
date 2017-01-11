<?php

namespace FindingAPI\Core\Processor\Get;

use FindingAPI\Core\ItemFilter\ItemFilterStorage;

use SDKBuilder\Dynamic\DynamicStorage;
use SDKBuilder\Processor\{ AbstractProcessor, ProcessorInterface };

use SDKBuilder\Processor\UrlifyInterface;
use SDKBuilder\Request\RequestInterface;

class GetItemFiltersProcessor extends AbstractProcessor implements ProcessorInterface
{
    /**
     * @var string $processed
     */
    private $processed = '';
    /**
     * @var ItemFilterStorage $itemFilterStorage
     */
    private $itemFilterStorage;
    /**
     * GetItemFiltersProcessor constructor.
     * @param RequestInterface $request
     * @param DynamicStorage $itemFilterStorage
     */
    public function __construct(RequestInterface $request, DynamicStorage $itemFilterStorage)
    {
        parent::__construct($request);

        $this->itemFilterStorage = $itemFilterStorage;
    }
    /**
     * @return ProcessorInterface
     */
    public function process() : ProcessorInterface
    {
        $finalProduct = '';
        $count = 0;

        $onlyAdded = $this->itemFilterStorage->filterAddedDynamics();

        if (!empty($onlyAdded)) {
            foreach ($onlyAdded as $name => $itemFilterItems) {
                $itemFilter = $this->itemFilterStorage->getDynamicInstance($name);

                if ($itemFilter instanceof UrlifyInterface) {
                    $finalProduct.=$itemFilter->urlify($count);
                }

                $count++;
            }

            $this->processed = $finalProduct.'&';
        }

        return $this;
    }
    /**
     * @return string
     */
    public function getProcessed() : string
    {
        return $this->processed;
    }
}