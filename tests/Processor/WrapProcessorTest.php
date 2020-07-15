<?php
/**
 * Created by PhpStorm.
 * @author Ewgeniy Kiselev <demroos@gmail.com>
 * Date: 15.07.2020
 * Time: 15:12
 */

namespace Processor;

use Demroos\Bundle\ApiGatewayBundle\Processor\WrapProcessor;
use PHPUnit\Framework\TestCase;

class WrapProcessorTest extends TestCase
{
    public function testProcess()
    {
        $processor = new WrapProcessor('data');
        $result = $processor->process(['test' => true]);
        $expectedResult = ['data' => ['test' => true]];
        $this->assertEquals($expectedResult, $result);
    }
}
