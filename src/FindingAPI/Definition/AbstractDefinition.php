<?php

namespace FindingAPI\Definition;

use FindingAPI\Core\Exception\DefinitionException;

abstract class AbstractDefinition implements SearchDefinitionInterface
{
    /**
     * @var array $definition;
     */
    protected $definition;
    /**
     * @var bool $isValidated
     */
    protected $isValidated = false;
    /**
     * AbstractDefinition constructor.
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
}