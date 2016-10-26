<?php

namespace FindingAPI\Processor\Factory;

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
        $requestParameters = $this->request->getRequestParameters();

        $method = $requestParameters->getParameter('method')->getValue();
        $itemFilters = $this->request->getItemFilterStorage();
        $definitions = $this->request->getDefinitions();

        $processors = array();
        $mainNamespace = 'FindingAPI\Processor\Get\\';

        $requestParametersProcessorClass = $mainNamespace.ucfirst($method).'RequestParametersProcessor';
        $keywordsProcessorClass = $mainNamespace.ucfirst($method).'KeywordsProcessor';
        $itemFiltersProcessorClass = $mainNamespace.ucfirst($method).'ItemFiltersProcessor';

        $processors['request-parameters-processor'] = new $requestParametersProcessorClass($this->request);
        $processors['keywords-processor'] = new $keywordsProcessorClass($this->request, $definitions);

        if (!empty($itemFilters)) {
            $processors['item-filters-processor'] = new $itemFiltersProcessorClass($this->request, $itemFilters);
        }

        return $processors;
    }
}