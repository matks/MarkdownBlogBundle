<?php

namespace Matks\MarkdownBlogBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('markdown_blog_bundle');

        $rootNode
            ->children()
            ->scalarNode('posts_directory')->end()
            ->end();

        return $treeBuilder;
    }
}
