<?php

namespace FindingAPI\Definition;

use FindingAPI\Definition\Exception\DefinitionException;

class OrOperator extends AbstractDefinition
{
    /**
     * @throws DefinitionException
     */
    public function validateDefinition()
    {
        $this->isValidated = true;

        $result = preg_match_all('/[\\-\\+]/', $this->definition);

        if ($result !== 0) {
            throw new DefinitionException('\'or\' operator search can only contain search word inside parenthesis separated by commas. Characters - + are forbidden');
        }

        $firstChar = substr($this->definition, 0, 1);
        $lastChar = substr($this->definition, -1);

        if ($firstChar !== '(' or $lastChar !== ')') {
            throw new DefinitionException('\'or\' operator search string has to begin with an opening parenthesis and end with a closing parenthesis with words separated by commas');
        }
    }
}