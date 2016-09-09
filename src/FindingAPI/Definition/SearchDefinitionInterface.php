<?php

namespace FindingAPI\Definition;

use FindingAPI\Definition\Exception\DefinitionException;

interface SearchDefinitionInterface
{
    /**
     * @return string
     */
    public function getDefinition() : string;
    /**
     * @throws DefinitionException
     */
    public function validateDefinition();
}