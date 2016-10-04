<?php

namespace FindingAPI\Processor;

use FindingAPI\Processor\Factory\DefinitionTypeInterface;

class GetDefinitionType implements DefinitionTypeInterface
{
    /**
     * @var array $definitions
     */
    private $definitions;
    /**
     * @var string $finalDefinition
     */
    private $finalDefinition;
    /**
     * @param array $definitions
     */
    public function addDefinitions(array $definitions) : DefinitionTypeInterface
    {
        $this->definitions = $definitions;

        return $this;
    }
    /**
     * @return string
     */
    public function process() : DefinitionTypeInterface
    {


        return $this;
    }
    /**
     * @return string
     */
    public function getProcessed() : string
    {
        return $this->finalDefinition;
    }
}