<?php

namespace SDKBuilder\Configuration;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\Exception\InvalidTypeException;

class Configuration implements ConfigurationInterface
{
    /**
     * @var string $apiKey
     */
    private $apiKey;
    /**
     * FindingConfiguration constructor.
     * @param string $apiKey
     */
    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }
    /**
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('sdk');

        $rootNode
            ->children()
                ->arrayNode($this->apiKey)
                    ->children()
                        ->scalarNode('request_class')->defaultValue('SDKBuilder\\Request\\Request')->end()
                        ->scalarNode('api_class')->cannotBeEmpty()->end()
                        ->arrayNode('request_validators')->prototype('scalar')->end()->end()
                        ->arrayNode('global_parameters')
                            ->useAttributeAsKey('name')
                            ->prototype('array')
                                ->children()
                                    ->scalarNode('representation')->isRequired()->end()
                                    ->scalarNode('value')->end()
                                    ->arrayNode('type')->prototype('scalar')->isRequired()->cannotBeEmpty()->end()->end()
                                    ->variableNode('valid')
                                        ->validate()
                                        ->always(function ($v) {
                                            if (is_null($v) || is_array($v)) {
                                                return $v;
                                            }

                                            throw new InvalidTypeException();
                                        })
                                    ->end()->end()
                                    ->booleanNode('deprecated')->defaultValue(false)->end()
                                    ->booleanNode('throws_exception_if_deprecated')->defaultValue(false)->end()
                                    ->booleanNode('obsolete')->defaultValue(false)->end()
                                    ->scalarNode('error_message')->defaultValue('Invalid value for %s: %s')->end()
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('special_parameters')
                            ->useAttributeAsKey('name')
                            ->prototype('array')
                                ->children()
                                    ->scalarNode('representation')->cannotBeEmpty()->isRequired()->end()
                                    ->scalarNode('value')->end()
                                    ->arrayNode('type')->prototype('scalar')->isRequired()->cannotBeEmpty()->end()->end()
                                    ->variableNode('valid')
                                    ->validate()
                                    ->always(function ($v) {
                                        if (is_null($v) || is_array($v)) {
                                            return $v;
                                        }

                                        throw new InvalidTypeException();
                                    })
                                    ->end()->end()
                                    ->booleanNode('deprecated')->end()
                                    ->booleanNode('throws_exception_if_deprecated')->end()
                                    ->booleanNode('obsolete')->end()
                                    ->scalarNode('error_message')->end()
                                ->end()
                            ->end()
                        ->end()
                            ->arrayNode('methods')
                                ->children()
                                    ->scalarNode('valid_methods')->isRequired()->cannotBeEmpty()->end()
                                    ->arrayNode('metadata')
                                        ->prototype('array')
                                            ->children()
                                                ->scalarNode('name')->isRequired()->cannotBeEmpty()->end()
                                                ->scalarNode('object')->isRequired()->cannotBeEmpty()->end()
                                                ->arrayNode('methods')->prototype('scalar')->isRequired()->cannotBeEmpty()->end()
                                            ->end()
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}