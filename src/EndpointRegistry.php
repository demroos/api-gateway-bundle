<?php
/**
 * Created by PhpStorm.
 * @author Ewgeniy Kiselev <demroos@gmail.com>
 * Date: 11.07.2020
 * Time: 17:43
 */

namespace Demroos\Bundle\ApiGatewayBundle;

use Demroos\Bundle\ApiGatewayBundle\Contracts\EndpointLoaderInterface;

class EndpointRegistry
{
    /** @var array| Endpoint[] */
    protected array $endpoints = [];

    /**
     * EndpointRegistry constructor.
     * @param iterable|EndpointLoaderInterface[] $loaders
     */
    public function __construct(iterable $loaders)
    {
        foreach ($loaders as $loader) {
            $this->endpoints = array_merge($this->endpoints, $loader->load());
        }
    }


    public function create($name, $path, $method, $config = [])
    {
        $this->add(new Endpoint($name, $path, $method, $config));
    }

    /**
     * @param $name
     * @return Endpoint|null
     */
    public function get($name)
    {
        foreach ($this->endpoints as $endpoint) {
            if ($endpoint->getName() === $name) {
                return $endpoint;
            }
        }
        return null;
    }

    public function add(Endpoint $endpoint)
    {
        $this->endpoints[] = $endpoint;
    }

    /**
     * @return array|Endpoint[]
     */
    public function all(): array
    {
        return $this->endpoints;
    }
}
