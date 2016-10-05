<?php

namespace FindingAPI\Processor\Get;

use FindingAPI\Core\ItemFilter\ItemFilterStorage;
use FindingAPI\Processor\AbstractProcessor;
use FindingAPI\Processor\ProcessorInterface;
use FindingAPI\Core\Request;
use FindingAPI\Processor\UrlifyInterface;

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

    public function __construct(Request $request, ItemFilterStorage $itemFilterStorage)
    {
        parent::__construct($request);

        $this->itemFilterStorage = $itemFilterStorage;
    }

    /**
     * @return string
     * @throws \FindingAPI\Core\Exception\RequestException
     */
    public function process() : ProcessorInterface
    {
        $finalProduct = '';
        $count = 0;
        foreach ($this->itemFilterStorage as $name => $itemFilterItems) {
            $itemFilter = $this->itemFilterStorage->getItemFilterInstance($name);

            if ($itemFilter instanceof UrlifyInterface) {
                $finalProduct.=$itemFilter->urlify($count);
            }

            $count++;
        }

        $this->processed = rtrim($finalProduct, '&');

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