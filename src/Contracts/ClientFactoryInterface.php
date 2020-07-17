<?php
/**
 * Created by PhpStorm.
 * @author Ewgeniy Kiselev <demroos@gmail.com>
 * Date: 17.07.2020
 * Time: 18:07
 */

namespace Demroos\Bundle\ApiGatewayBundle\Contracts;

use GuzzleHttp\ClientInterface;

interface ClientFactoryInterface
{
    public function __invoke(): ClientInterface;
}
