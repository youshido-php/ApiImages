<?php

namespace Youshido\ImagesBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('images');

        $rootNode
            ->children()
                ->scalarNode('web_root')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('path_prefix')->cannotBeEmpty()->defaultValue('uploads/images')->end()
                ->enumNode('platform')->values(['odm', 'orm'])->defaultValue('orm')->cannotBeEmpty()->end()
                ->enumNode('driver')->values(['gd', 'imagick', 'gmagick'])->defaultValue('gd')->cannotBeEmpty()->end()
                ->arrayNode('routing')
                    ->addDefaultsIfNotSet()
                    ->canBeUnset()
                    ->children()
                        ->scalarNode('host')->defaultNull()->end()
                        ->scalarNode('scheme')->defaultNull()->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
