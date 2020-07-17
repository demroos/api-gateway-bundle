<?php
/**
 * Created by PhpStorm.
 * @author Ewgeniy Kiselev <demroos@gmail.com>
 * Date: 17.07.2020
 * Time: 16:51
 */

namespace Demroos\Bundle\ApiGatewayBundle\Tests;

use Demroos\Bundle\ApiGatewayBundle\Tests\app\TestKernel;
use PHPUnit\Framework\TestCase;

class ApiGatewayBundleTest extends TestCase
{
    public function testRunApp()
    {
        $kernel = new TestKernel('dev', true);
        $kernel->boot();
        $this->assertTrue(true);
    }

}
