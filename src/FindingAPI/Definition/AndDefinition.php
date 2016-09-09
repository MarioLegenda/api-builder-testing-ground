<?php

namespace FindingAPI\Definition;

use FindingAPI\Definition\Exception\DefinitionException;

class AndDefinition implements SearchDefinitionInterface
{
    /**
     * @var array $definition;
     */
    private $definition;
    /**
     * @var bool $isValidated
     */
    private $isValidated = false;
    /**
     * AndDefinition constructor.
     * @param string $searchString
     */
    public function __construct(string $searchString)
    {
        $this->definition = $searchString;
    }
    /**
     * @return string
     * @throws DefinitionException
     */
    public function getDefinition() : string
    {
        if ($this->isValidated === false) {
            throw new DefinitionException(get_class($this).' should be validated first with SearchDefinitionInterface::validateDefinition');
        }

        return $this->definition;
    }
    /**
     * @throws DefinitionException
     */
    public function validateDefinition()
    {
        $this->isValidated = true;

        $result = preg_match_all('/[,\\-\\)\\(\\+]/', $this->definition);

        if ($result !== 0) {
            throw new DefinitionException('\'and\' operator search can only contain spaces between words. Characters , - ( ) + are forbidden');
        }
    }
}