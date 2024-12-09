<?php

declare(strict_types=1);

namespace Dbp\Relay\VerityConnectorVerapdfBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('dbp_relay_verity_connector_verapdf');

        $treeBuilder->getRootNode()
            ->children()
                ->scalarNode('url')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('maxsize')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
