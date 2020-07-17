<?php
/**
 * Created by PhpStorm.
 * @author Ewgeniy Kiselev <demroos@gmail.com>
 * Date: 17.07.2020
 * Time: 14:53
 */

namespace Demroos\Bundle\ApiGatewayBundle\Tests\DependencyInjection;

use Demroos\Bundle\ApiGatewayBundle\DependencyInjection\Configuration;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Definition\Processor;

class ConfigurationTest extends TestCase
{
    public function testDefaultConfig()
    {
        $processor = new Processor();
        $config = $processor->processConfiguration(new Configuration(), []);
        $expectedConfig = ['endpoints' => []];
        $this->assertEquals($expectedConfig, $config);
    }

}
