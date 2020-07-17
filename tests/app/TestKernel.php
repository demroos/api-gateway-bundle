<?php
/**
 * Created by PhpStorm.
 * @author Ewgeniy Kiselev <demroos@gmail.com>
 * Date: 17.07.2020
 * Time: 16:49
 */

namespace Demroos\Bundle\ApiGatewayBundle\Tests\app;

use Demroos\Bundle\ApiGatewayBundle\ApiGatewayBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;

class TestKernel extends Kernel
{

    public function registerBundles()
    {
        return [
            new FrameworkBundle(),
            new ApiGatewayBundle()
        ];
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {

    }
}
