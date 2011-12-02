<?php

namespace Problematic\TutorialBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;

class Configuration
{

    public function getConfigTree()
    {
        $tb = new TreeBuilder();

        $tb->root('problematic_tutorial', 'array')
            ->children()
                ->arrayNode('class')->isRequired()
                    ->children()
                        ->scalarNode('tutorial')->isRequired()->end()
                    ->end()
                ->end()
            ->end()
        ->end();

        return $tb->buildTree();
    }

}
