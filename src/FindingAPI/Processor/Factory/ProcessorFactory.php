<?php

namespace FindingAPI\Processor\Factory;

use FindingAPI\Core\Request;

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

        $requestParametersProcessor = $mainNamespace.ucfirst($method).'RequestParametersProcessor';
        $keywordsProcessor = $mainNamespace.ucfirst($method).'KeywordsProcessor';

        $processors['request-parameters-processor'] = new $requestParametersProcessor($this->request);
        $processors['keywords-processor'] = new $keywordsProcessor($this->request, $definitions);

        if (!empty($itemFilters)) {
            // TODO: put item filter processor in $processors
        }

        return $processors;
    }
}