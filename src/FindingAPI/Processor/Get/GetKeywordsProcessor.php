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
    private $processed;
    /**
     * @var DefinitionTypeInterface
     */
    private $definitionType;
    /**
     * GetKeywordsProcessor constructor.
     * @param Request $request
     * @param DefinitionTypeInterface $definitionType
     */
    public function __construct(Request $request, DefinitionTypeInterface $definitionType)
    {
        parent::__construct($request);

        $this->definitionType = $definitionType;
    }

    /**
     * @return string
     */
    public function process() : ProcessorInterface
    {
        $processed = $this->definitionType->getProcessed();

        $keywords = urlencode($processed);

        $processed = '';

        $processed.='keywords='.$keywords;

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