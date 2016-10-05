<?php

namespace FindingAPI\Processor\Get;

use FindingAPI\Processor\AbstractProcessor;
use FindingAPI\Processor\ProcessorInterface;
use FindingAPI\Core\Request;
use FindingAPI\Processor\Factory\DefinitionTypeInterface;

class GetKeywordsProcessor extends AbstractProcessor implements ProcessorInterface
{
    /**
     * @var string $processed
     */
    private $processed = '';
    /**
     * @var array
     */
    private $definitions;
    /**
     * GetKeywordsProcessor constructor.
     * @param Request $request
     * @param array $definitions
     */
    public function __construct(Request $request, array $definitions)
    {
        parent::__construct($request);

        $this->definitions = $definitions;
    }

    /**
     * @return string
     */
    public function process() : ProcessorInterface
    {
        $finalDefinition = '';
        foreach ($this->definitions as $definition) {
            $finalDefinition.=$definition->getDefinition().' ';
        }

        $finalDefinition = rtrim($finalDefinition);

        $keywords = urlencode($finalDefinition);

        $processed = '';

        $processed.='keywords='.$keywords.'&';

        $this->processed = $processed;

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