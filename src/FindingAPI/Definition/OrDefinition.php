<?php

namespace FindingAPI\Definition;

use FindingAPI\Definition\Exception\DefinitionException;

class OrDefinition extends AbstractDefinition
{
    /**
     * @throws DefinitionException
     */
    public function validateDefinition()
    {
        $this->isValidated = true;

        $this->definition = preg_replace('/\s/', '', $this->definition);

        $result = preg_match_all('/[\\-\\+]/', $this->definition);

        if ($result !== 0) {
            throw new DefinitionException('\'or\' operator search can only contain search word inside parenthesis separated by commas. Characters - + are forbidden');
        }

        $result = preg_split('/,/', $this->definition);

        if (count($result) === 1) {
            throw new DefinitionException('\'or\' operator can accept only searches that search for a minimal of two occurences. For example (harry, potter)');
        }

        $firstChar = substr($this->definition, 0, 1);
        $lastChar = substr($this->definition, -1);

        if ($firstChar !== '(' or $lastChar !== ')') {
            throw new DefinitionException('\'or\' operator search string has to begin with an opening parenthesis and end with a closing parenthesis with words separated by commas');
        }
    }
}