<?php

namespace FindingAPI\Definition;

use FindingAPI\Definition\Exception\DefinitionException;

class NotDefinition extends AbstractDefinition
{
    /**
     * @throws DefinitionException
     */
    public function validateDefinition()
    {
        $this->isValidated = true;

        $result = preg_match_all('/[,\)\(\+]/', $this->definition);

        if ($result !== 0) {
            throw new DefinitionException('\'not\' operator search can only contain spaces between words. Characters , ( ) + are forbidden');
        }

        // TO BE IMPLEMENTED
        //$result = preg_match('/^(\w+)\s+\-(\w+)$/', $this->definition);
/*
        if ($result !== 0) {
            throw new DefinitionException('\'not\' has to have one search word followed by another with a dash in front of it separated by a spaces');
        }*/
    }
}