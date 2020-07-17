<?php
/**
 * Created by PhpStorm.
 * @author Ewgeniy Kiselev <demroos@gmail.com>
 * Date: 11.07.2020
 * Time: 16:00
 */

namespace Demroos\Bundle\ApiGatewayBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{

    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('api_gateway');

        if (method_exists($treeBuilder, 'getRootNode')) {
            $rootNode = $treeBuilder->getRootNode();
        } else {
            // BC for symfony/config < 4.2
            /** @noinspection PhpUndefinedMethodInspection */
            $rootNode = $treeBuilder->root('api_gateway');
        }

        $rootNode
            ->children()
                ->arrayNode('endpoints')
                    ->useAttributeAsKey('name')
                    ->normalizeKeys(false)
                    ->arrayPrototype()
                        ->children()
                            ->scalarNode('url')->end()
                            ->scalarNode('method')->end()
                            ->arrayNode('config')
                                ->children()
                                    ->scalarNode('url')->end()
                                    ->scalarNode('method')->end()
                                    ->arrayNode('transform')
                                        ->arrayPrototype()
                                            ->children()
                                                ->scalarNode('type')->end()
                                                ->arrayNode('scope')
                                                    ->scalarPrototype()->end()
                                                ->end()
                                                ->scalarNode('key')->end() // wrap
                                            ->end()
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('client_factory')
                    ->children()
                        ->scalarNode('service')->end()
                        ->variableNode('config')->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
