<?php

namespace SDKBuilder\Processor\Factory;

 use FindingAPI\Core\Request\Request;

class ProcessorFactory
{
    /**
     * @var array $processors
     */
    private $processors = array();
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

    public function registerProcessor() : ProcessorFactory
    {
        return $this;
    }
    /**
     * @return array
     */
    public function createProcessors() : array
    {
        $method = $this->request->getMethod();
        $itemFilters = $this->request->getItemFilterStorage();

        $processors = array();
        $mainNamespace = 'SDKBuilder\Processor\Get\\';

        $requestParametersProcessorClass = $mainNamespace.ucfirst($method).'RequestParametersProcessor';
        $processors['request-parameters-processor'] = new $requestParametersProcessorClass($this->request);

        if (!empty($itemFilters)) {
            $itemFiltersProcessorClass = $mainNamespace.ucfirst($method).'ItemFiltersProcessor';

            $processors['item-filters-processor'] = new $itemFiltersProcessorClass($this->request, $itemFilters);
        }

        return $processors;
    }
}