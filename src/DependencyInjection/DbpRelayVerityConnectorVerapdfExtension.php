<?php

declare(strict_types=1);

namespace Dbp\Relay\VerityConnectorVerapdfBundle\DependencyInjection;

use Dbp\Relay\CoreBundle\Extension\ExtensionTrait;
// use Dbp\Relay\VerityBundle\Service\ConfigurationService;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;

class DbpRelayVerityConnectorVerapdfExtension extends ConfigurableExtension
{
    use ExtensionTrait;

    public function loadInternal(array $mergedConfig, ContainerBuilder $container): void
    {
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../Resources/config')
        );
        $loader->load('services.yaml');

        // TODO: Implement service configuration
        // $definition = $container->getDefinition(ConfigurationService::class);
        // $definition->addMethodCall('setConfig', [$mergedConfig]);
    }
}
