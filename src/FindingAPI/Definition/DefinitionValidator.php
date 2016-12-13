<?php

namespace FindingAPI\Definition;

class DefinitionValidator
{
    /**
     * @var array $validators
     */
    private $validators = array();
    /**
     * DefinitionValidator constructor.
     */
    public function __construct()
    {
        $this->validators[] = function (string $searchString) {
            $result = preg_match_all('/[,\\-\\)\\(\\+]/', $searchString);

            if ($result !== 0) {
                return false;
            }

            return 'andOperator';
        };

        $this->validators[] = function (string $searchString) {
            $tempResult = preg_replace('/\s+/', '', $searchString);
            $result = preg_match_all('/[\\-\\)\\(\\+]/', $tempResult);

            if ($result !== 0) {
                return false;
            }

            $result = strpos($searchString, ',');

            if ($result === false) {
                return false;
            }

            return 'exactSequence';
        };

        $this->validators[] = function (string $searchString) {

            $searchString = preg_replace('/\s/', '', $searchString);

            $result = preg_match_all('/[\\-\\+]/', $searchString);

            if ($result !== 0) {
                return false;
            }

            $result = preg_split('/,/', $searchString);

            if (count($result) === 1) {
                return false;
            }

            $firstChar = substr($searchString, 0, 1);
            $lastChar = substr($searchString, -1);

            if ($firstChar !== '(' or $lastChar !== ')') {
                return false;
            }

            return 'orOperator';
        };

        $this->validators[] = function (string $searchString) {
            $result = preg_match_all('/[,\\)\\(\\+]/', $searchString);

            if ($result !== 0) {
                return false;
            }

            // TO BE IMPLEMENTED
            //$result = preg_match('#\w+\s+\\-\w+#', $this->definition);

            if ($result !== 0) {
                return false;
            }

            return 'notOperator';
        };
    }
    /**
     * @param string $searchString
     * @return bool
     */
    public function findDefinition(string $searchString)
    {
        foreach ($this->validators as $definition) {
            $operator = $definition->__invoke($searchString);

            if ($operator !== false) {
                return $operator;
            }
        }

        return false;
    }
}