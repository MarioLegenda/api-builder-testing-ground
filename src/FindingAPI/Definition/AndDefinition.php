<?php

namespace FindingAPI\Definition;

use FindingAPI\Definition\Exception\DefinitionException;

class AndDefinition implements SearchDefinitionInterface
{
    /**
     * @var array $definition;
     */
    private $searchString;
    /**
     * @var array $processedDefinition
     */
    private $processedDefinition;
    /**
     * AndDefinition constructor.
     * @param string $searchString
     */
    public function __construct(string $searchString)
    {
        $this->searchString = $searchString;
    }
    /**
     * @return array
     */
    public function getProcessedDefinition() : array
    {
        $this->processedDefinition = preg_split('#\s#', $this->searchString);

        return $this->processedDefinition;
    }
    /**
     * @throws DefinitionException
     */
    public function validateDefinition()
    {
        $result = preg_match_all('/[,\\-\\)\\(\\+]/', $this->searchString);

        if ($result !== 0) {
            throw new DefinitionException('\'and\' operator search can only contain spaces between words. Characters , - ( ) + are forbidden');
        }
    }
}