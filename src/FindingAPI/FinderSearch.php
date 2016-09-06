<?php

namespace FindingAPI;

use FindingAPI\Definition\SearchDefinitionInterface;

class FinderSearch
{
    /**
     * @var Configuration $configuration
     */
    private $request;
    /**
     * @var FinderSearch $instance
     */
    private static $instance;
    /**
     * @param Configuration|null $configuration
     * @return FinderSearch
     */
    public static function getInstance(Request $request) : FinderSearch
    {
        self::$instance = (self::$instance instanceof self) ? self::$instance : new FinderSearch($configuration);

        return self::$instance;
    }
    /**
     * FinderSearch constructor.
     * @param Configuration $configuration
     */
    private function __construct(Request $request)
    {
        $this->request = $request;
    }
    /**
     * @param SearchDefinitionInterface $definition
     * @return $this
     */
    public function search(SearchDefinitionInterface $definition)
    {
        return $this;
    }
}