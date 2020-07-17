<?php
/**
 * Created by PhpStorm.
 * @author Ewgeniy Kiselev <demroos@gmail.com>
 * Date: 17.07.2020
 * Time: 18:28
 */

namespace Demroos\Bundle\ApiGatewayBundle\Tests\app;

use Demroos\Bundle\ApiGatewayBundle\Contracts\ClientFactoryInterface;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;

class TestFactory implements ClientFactoryInterface
{

    public function __invoke(): ClientInterface
    {
        return new Client();
    }
}
