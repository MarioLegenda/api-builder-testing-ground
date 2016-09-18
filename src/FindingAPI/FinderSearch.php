<?php

namespace FindingAPI;

use FindingAPI\Core\Options;
use FindingAPI\Definition\DefinitionFactory;
use FindingAPI\Definition\DefinitionValidator;
use FindingAPI\Definition\Exception\DefinitionException;
use FindingAPI\Definition\SearchDefinitionInterface;
use FindingAPI\Core\Request;
use FindingAPI\Definition\Type\DefinitionTypeFactory;
use FindingAPI\Definition\Type\UrlDefinitionType;
use FindingAPI\Processor\ProcessorFactory;

class FinderSearch
{
    /**
     * @var Request $configuration
     */
    private $request;
    /**
     * @var Options $options
     */
    private $options;
    /**
     * @var static FinderSearch $instance
     */
    private static $instance;
    /**
     * @var array $definitions
     */
    private $definitions = array();
    /**
     * @var string $processed
     */
    private $processed;

    /**
     * @param Request|null $configuration
     * @return FinderSearch
     */
    public static function getInstance(Request $request) : FinderSearch
    {
        if (self::$instance instanceof self) {
            return self::$instance;
        }

        self::$instance = new FinderSearch($request);

        self::$instance->options = new Options();

        DefinitionFactory::initiate(self::$instance->options);

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
    public function addSearch(SearchDefinitionInterface $definition) : FinderSearch
    {
        try {
            $definition->validateDefinition();
        } catch (DefinitionException $e) {
            if ($this->options->hasOption(Options::SMART_GUESS_SYSTEM)) {
                $definitionMethod = (new DefinitionValidator())->findDefinition($definition->getDefinition());

                if ($definitionMethod === false) {
                    throw new DefinitionException($e->getMessage());
                }

                $definition = DefinitionFactory::$definitionMethod($definition->getDefinition());

                $definition->validateDefinition();
            }
        }

        $this->definitions[] = $definition;

        return $this;
    }

    /**
     * @param int $option
     * @return FinderSearch
     */
    public function addOption(int $option) : FinderSearch
    {
        $this->options->addOption($option);

        return $this;
    }
    /**
     * @return string
     */
    public function getProcessed()
    {
        return $this->processed;
    }
    /**
     * @return FinderSearch
     * @throws Core\Exception\FindingApiException
     */
    public function send() : FinderSearch
    {
        $definitionType = (new DefinitionTypeFactory($this->request))
            ->getDefinitionType()
            ->addDefinitions($this->definitions)
            ->process();

        $processed = ProcessorFactory::getProcessor($this->request, $definitionType)->process();

        $this->processed = $processed;

        $this->request->sendRequest($processed);

        return $this;
    }
}