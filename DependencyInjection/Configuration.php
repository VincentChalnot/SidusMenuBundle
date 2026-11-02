<?php /** @noinspection NullPointerExceptionInspection */

declare(strict_types=1);

namespace Sidus\MenuBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 */
class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('sidus_menu');

        /** @formatter:off */
        $treeBuilder->getRootNode()
            ->children()
                ->arrayNode('global_options')
                    ->defaultValue([])
                    ->normalizeKeys(false)
                    ->variablePrototype()->end()
                ->end()
            ->arrayNode('menus')
                ->normalizeKeys(false)
                ->useAttributeAsKey('code')
                ->arrayPrototype()
                    ->children()
                        ->scalarNode('template')->isRequired()->cannotBeEmpty()->end()
                        ->scalarNode('menu_item_template')->isRequired()->cannotBeEmpty()->end()
                        ->arrayNode('options')
                            ->defaultValue([])
                            ->normalizeKeys(false)
                            ->variablePrototype()->end()
                        ->end()
                        ->arrayNode('items')
                            ->isRequired()
                            ->arrayPrototype()
                                ->children()
                                    ->scalarNode('path')->defaultNull()->end()
                                    ->scalarNode('template')->defaultNull()->end()
                                    ->scalarNode('title')->defaultNull()->end()
                                    ->scalarNode('priority')->defaultValue(0)->end()
                                    ->scalarNode('icon')->defaultNull()->end()
                                    ->arrayNode('security')
                                        ->children()
                                            ->scalarNode('role')->isRequired()->cannotBeEmpty()->end()
                                            ->scalarNode('object')->defaultNull()->end()
                                        ->end()
                                    ->end()
                                    ->arrayNode('roles')
                                        ->defaultValue([])
                                        ->normalizeKeys(false)
                                        ->scalarPrototype()->end()
                                    ->end()
                                    ->arrayNode('attributes')
                                        ->defaultValue([])
                                        ->normalizeKeys(false)
                                        ->variablePrototype()->end()
                                    ->end()
                                    ->arrayNode('options')
                                        ->defaultValue([])
                                        ->normalizeKeys(false)
                                        ->variablePrototype()->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
        /** @formatter:on */

        return $treeBuilder;
    }
}
