<?php

declare(strict_types=1);

namespace FindingAPI\Definition;

class Definition
{
    /**
     * @param string $searchString
     * @return SearchDefinitionInterface
     */
    public static function andOperator(string $searchString) : SearchDefinitionInterface
    {
        return new AndDefinition($searchString);
    }
}