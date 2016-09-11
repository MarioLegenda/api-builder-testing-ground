<?php

declare(strict_types=1);

namespace FindingAPI\Definition;

class DefinitionFactory
{
    /**
     * @param string $searchString
     * @return SearchDefinitionInterface
     */
    public static function andOperator(string $searchString) : SearchDefinitionInterface
    {
        return new AndDefinition($searchString);
    }
    /**
     * @param string $searchString
     * @return SearchDefinitionInterface
     */
    public static function exactSearchOperator(string $searchString) : SearchDefinitionInterface
    {
        return new ExactSequenceDefinition($searchString);
    }
    /**
     * @param string $searchString
     * @return SearchDefinitionInterface
     */
    public static function orOperator(string $searchString) : SearchDefinitionInterface
    {
        return new OrOperator($searchString);
    }
}