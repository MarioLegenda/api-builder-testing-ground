<?php

namespace FindingAPI\Definition;

class AndDefinition implements SearchDefinitionInterface
{
    /**
     * @var array $definition;
     */
    private $definition;
    /**
     * AndDefinition constructor.
     * @param string $searchString
     */
    public function __construct(string $searchString)
    {
        $this->definition = preg_split('#\s#', $searchString);
    }
    /**
     * @return array
     */
    public function getProcessedDefinition() : array
    {
        return $this->definition;
    }
}