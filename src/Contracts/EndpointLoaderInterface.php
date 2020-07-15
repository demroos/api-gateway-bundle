<?php
/**
 * Created by PhpStorm.
 * @author Ewgeniy Kiselev <demroos@gmail.com>
 * Date: 11.07.2020
 * Time: 17:52
 */

namespace Demroos\Bundle\ApiGatewayBundle\Contracts;


use Demroos\Bundle\ApiGatewayBundle\Endpoint;

interface EndpointLoaderInterface
{
    /**
     * @return array|Endpoint[]
     */
    public function load(): array ;
}
