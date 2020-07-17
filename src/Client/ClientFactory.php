<?php
/**
 * Created by PhpStorm.
 * @author Ewgeniy Kiselev <demroos@gmail.com>
 * Date: 17.07.2020
 * Time: 14:27
 */

namespace Demroos\Bundle\ApiGatewayBundle\Client;

use Demroos\Bundle\ApiGatewayBundle\Contracts\ClientFactoryInterface;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;

class ClientFactory implements ClientFactoryInterface
{
    private array $config;

    /**
     * ClientFactory constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    public function __invoke(): ClientInterface
    {
        return new Client($this->config);
    }
}
