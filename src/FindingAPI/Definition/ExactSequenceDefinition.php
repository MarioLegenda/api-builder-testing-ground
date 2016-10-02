<?php

namespace FindingAPI\Definition;

use FindingAPI\Definition\Exception\DefinitionException;

class ExactSequenceDefinition extends AbstractDefinition
{
    /**
     * @throws DefinitionException
     */
    public function validateDefinition()
    {
        $this->isValidated = true;

        $tempResult = preg_replace('/\s+/', '', $this->definition);
        $result = preg_match_all('/[\\-\\)\\(\\+\\s]/', $tempResult);

        if ($result !== 0) {
            throw new DefinitionException('\'exact sequence\' operator search can only contain a comma (,) between words. Characters - ( ) + and spaces are forbidden');
        }

        $result = strpos($this->definition, ',');

        if ($result === false) {
            throw new DefinitionException('\'exact sequence\' operator search can only contain a comma (,) between words. Characters - ( ) + and spaces are forbidden');
        }
    }
}