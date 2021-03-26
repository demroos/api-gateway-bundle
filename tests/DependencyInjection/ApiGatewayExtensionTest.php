<?php
/**
 * Created by PhpStorm.
 * @author Ewgeniy Kiselev <demroos@gmail.com>
 * Date: 17.07.2020
 * Time: 16:38
 */

namespace Demroos\Bundle\ApiGatewayBundle\Tests\DependencyInjection;

use Demroos\Bundle\ApiGatewayBundle\ApiGatewayBundle;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ApiGatewayExtensionTest extends TestCase
{
    public function testLoad()
    {
        $config = [
            'api_gateway' => [
                'endpoints' => [
                    'api_test' => [
                        'url' => '/api/test',
                        'method' => 'post',
                        'config' => [
                            'url' => 'backend/api/test',
                            'method' => 'post',
                        ]
                    ]
                ]
            ]
        ];

        $container = $this->getContainerForConfigLoad($config);

        $calls = $container->getDefinition('api_gateway.endpoint_registry')->getMethodCalls();

        $this->assertCount(1, $calls);

        list($name, $arguments) = $calls[0];

        $this->assertEquals('create', $name);

        $this->assertCount(4, $arguments);
        $this->assertEquals('api_test', $arguments[0]);
        $this->assertEquals('/api/test', $arguments[1]);
        $this->assertEquals('post', $arguments[2]);

        $config = $arguments[3];
        $this->assertEquals('backend/api/test', $config['url']);
        $this->assertEquals('post', $config['method']);
    }

    public function testClientFactoryConfig()
    {
        $config = [
            'api_gateway' => [
                'client_factory' => [
                    'config' => ['http_errors' => false]
                ]
            ]
        ];
        $container = $this->getContainerForConfigLoad($config);

        $factoryDef = $container->getDefinition('api_gateway.client_factory');
        $this->assertCount(1, $factoryDef->getArguments());
        $this->assertEquals(['http_errors' => false], $factoryDef->getArgument(0));
    }

    public function testClientFactoryService()
    {
        $config = [
            'api_gateway' => [
                'client_factory' => [
                    'service' => 'test_client_factory'
                ]
            ]
        ];

        $container = $this->getContainerForConfigLoad($config);

        $clientDef = $container->getDefinition('api_gateway.client');
        $factory = $clientDef->getFactory();
        $this->assertCount(2, $factory);
        /**
         * @var $ref Reference
         */
        list($ref, $method) = $factory;
        $this->assertEquals('test_client_factory', $ref->__toString());
        $this->assertEquals('__invoke', $method);
    }

    public function testConfigParamsLoad()
    {
        $config = [
            'api_gateway' => [
                'config' => [
                    'headers' => ['Content-Type']
                ]
            ]
        ];

        $container = $this->getContainerForConfigLoad($config);

        $configParam = $container->getParameter('api_gateway.config');

        $this->assertEquals([
            'headers' => ['Content-Type']
        ], $configParam);
    }


    private function getContainerForConfigLoad($config): ContainerBuilder
    {
        $container = new ContainerBuilder();
        $bundle = new ApiGatewayBundle();
        $extension = $bundle->getContainerExtension();
        $extension->load($config, $container);

        return $container;
    }
}
