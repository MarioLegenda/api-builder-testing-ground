<?php

namespace FindingAPI;

use FindingAPI\Definition\DefinitionProcessor;
use FindingAPI\Definition\SearchDefinitionInterface;
use FindingAPI\Core\Request;
use FindingAPI\Definition\Type\DefinitionTypeFactory;
use FindingAPI\Definition\Type\UrlDefinitionType;

class FinderSearch
{
    /**
     * @var Request $configuration
     */
    private $request;
    /**
     * @var FinderSearch $instance
     */
    private static $instance;
    /**
     * @var array $definitions
     */
    private $definitions = array();
    /**
     * @param Request|null $configuration
     * @return FinderSearch
     */
    public static function getInstance(Request $request) : FinderSearch
    {
        self::$instance = (self::$instance instanceof self) ? self::$instance : new FinderSearch($request);

        return self::$instance;
    }
    /**
     * FinderSearch constructor.
     * @param Request $configuration
     */
    private function __construct(Request $request)
    {
        $this->request = $request;
    }
    /**
     * @param SearchDefinitionInterface $definition
     * @return FinderSearch
     */
    public function search(SearchDefinitionInterface $definition) : FinderSearch
    {
        $definition->validateDefinition();

        $this->definitions[] = $definition;

        return $this;
    }

    public function send()
    {
        $definitionType = (new DefinitionTypeFactory($this->request))
            ->getDefinitionType()
            ->addDefinitions($this->definitions)
            ->process();

        $this->request->sendRequest($definitionType);
    }
}