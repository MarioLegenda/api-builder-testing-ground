<?php

namespace FindingAPI\Definition;

use FindingAPI\Definition\Exception\DefinitionException;

class AndDefinition extends AbstractDefinition
{
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