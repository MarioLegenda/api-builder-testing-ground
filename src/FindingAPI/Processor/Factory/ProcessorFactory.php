<?php

namespace FindingAPI\Processor\Factory;

use FindingAPI\Core\Request\Method\FindItemsByKeywordsRequest;
use FindingAPI\Core\Request\Method\Method;
use FindingAPI\Core\Request\Request;

class ProcessorFactory
{
    /**
     * @var Request $request
     */
    private $request;
    /**
     * ProcessorFactory constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    /**
     * @return array
     */
    public function createProcessors() : array
    {
        $method = $this->request->getMethod();
        $itemFilters = $this->request->getItemFilterStorage();

        $processors = array();
        $mainNamespace = 'FindingAPI\Processor\Get\\';

        $requestParametersProcessorClass = $mainNamespace.ucfirst($method).'RequestParametersProcessor';
        $processors['request-parameters-processor'] = new $requestParametersProcessorClass($this->request);

        if (!empty($itemFilters)) {
            $itemFiltersProcessorClass = $mainNamespace.ucfirst($method).'ItemFiltersProcessor';

            $processors['item-filters-processor'] = new $itemFiltersProcessorClass($this->request, $itemFilters);
        }

        return $processors;
    }
}