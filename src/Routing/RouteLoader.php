<?php
/**
 * Created by PhpStorm.
 * @author Ewgeniy Kiselev <demroos@gmail.com>
 * Date: 10.07.2020
 * Time: 15:59
 */

namespace Demroos\Bundle\ApiGatewayBundle\Routing;

use Demroos\Bundle\ApiGatewayBundle\EndpointRegistry;
use RuntimeException;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class RouteLoader
{
    private bool $isLoaded = false;

    /**
     * @var EndpointRegistry
     */
    private EndpointRegistry $endpointRegistry;

    public function __construct(EndpointRegistry $endpointRegistry)
    {
        $this->endpointRegistry = $endpointRegistry;
    }


    public function __invoke()
    {
        if (true === $this->isLoaded) {
            throw new RuntimeException('Do not add the "extra" loader twice');
        }

        $routes = new RouteCollection();
        $endpoints = $this->endpointRegistry->all();

        foreach ($endpoints as $endpoint) {
            $defaults = [
                '_controller' => 'api_gateway.controller::singleRequest',
            ];
            $route = new Route($endpoint->getPath(), $defaults);
            $route->setMethods($endpoint->getMethod());
            $routes->add($endpoint->getName(), $route);
        }

        $this->isLoaded = true;

        return $routes;
    }
}
