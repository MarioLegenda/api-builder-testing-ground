<?php

namespace FindingAPI\Core\Processor\Get;

use FindingAPI\Core\ItemFilter\ItemFilterStorage;

use SDKBuilder\Processor\{ AbstractProcessor, ProcessorInterface };

use FindingAPI\Core\Request\Request;
use SDKBuilder\Processor\UrlifyInterface;

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
     * @param Request $request
     * @param ItemFilterStorage $itemFilterStorage
     */
    public function __construct(Request $request, ItemFilterStorage $itemFilterStorage)
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

        $onlyAdded = $this->itemFilterStorage->filterAddedFilter(array('SortOrder', 'PaginationInput'));

        if (!empty($onlyAdded)) {
            foreach ($onlyAdded as $name => $itemFilterItems) {
                $itemFilter = $this->itemFilterStorage->getItemFilterInstance($name);

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