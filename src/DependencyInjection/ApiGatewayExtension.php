<?php
/**
 * Created by PhpStorm.
 * @author Ewgeniy Kiselev <demroos@gmail.com>
 * Date: 11.07.2020
 * Time: 15:20
 */

namespace Demroos\Bundle\ApiGatewayBundle\DependencyInjection;

use Exception;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Reference;

class ApiGatewayExtension extends Extension
{
    /**
     * @param array $configs
     * @param ContainerBuilder $container
     * @throws Exception
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader(
            $container,
            new FileLocator(__DIR__ . '/../Resources/config')
        );
        $loader->load('services.xml');

        $configuration = new Configuration();

        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('api_gateway.config', $config['config']);

        if (isset($config['endpoints'])) {
            $registryDef = $container->getDefinition('api_gateway.endpoint_registry');

            foreach ($config['endpoints'] as $name => $ec) {
                $registryDef->addMethodCall('create', [$name, $ec['url'], $ec['method'], $ec['config']]);
            }
        }

        if (isset($config['client_factory'])) {
            $factoryNode = $config['client_factory'];

            if (isset($factoryNode['config'])) {
                $factoryDef = $container->getDefinition('api_gateway.client_factory');
                $factoryDef->setArgument(0, $factoryNode['config']);
            }

            if (isset($factoryNode['service'])) {
                $clientDef = $container->getDefinition('api_gateway.client');
                $clientDef->setFactory([new Reference($factoryNode['service']), '__invoke']);
            }
        }
    }
}
