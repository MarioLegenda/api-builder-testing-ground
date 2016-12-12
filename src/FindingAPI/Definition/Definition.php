<?php

declare(strict_types = 1);

namespace FindingAPI\Definition;

use FindingAPI\Core\Request\Options;

class Definition
{
    /**
     * @var static DefinitionFactory $instance
     */
    private static $instance;
    /**
     * @var Options $options
     */
    private $options;

    /**
     * @param Options $options
     */
    public static function initiate(Options $options)
    {
        self::$instance = (self::$instance instanceof self) ? self::$instance : new self($options);
    }
    /**
     * DefinitionFactory constructor.
     * @param Options $options
     */
    private function __construct(Options $options)
    {
        $this->options = $options;
    }
    /**
     * @param string $searchString
     * @return SearchDefinitionInterface
     */
    public static function customDefinition(string $searchString) : SearchDefinitionInterface
    {
        return new CustomDefinition($searchString);
    }
}