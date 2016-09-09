<?php

namespace FindingAPI\Definition\Type;

class UrlDefinitionType implements DefinitionTypeInterface
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
        $finalDefinition = '';
        foreach ($this->definitions as $definition) {
            $finalDefinition.=' '.$definition;
        }

        $this->finalDefinition = rtrim($finalDefinition);

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