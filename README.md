# ApiGatewayBundle

This bundle enables you to easily proxy requests. It stands as a gateway between your API and a number of external services.

## About package

This package will help you create an api gateway.

## Features

* Getting endpoints from bundle configuration
* Getting endpoints from loaders, see [EndpointLoaderInterface](src/Contracts/EndpointLoaderInterface.php)
* Feature for processing body request/response is coming soon

## Install
`composer require demroos/api-gateway-bundle`

### Enable bundle

in config/bundles.php
```php
<?php

return [
    // other bundles,                            
    Demroos\Bundle\ApiGatewayBundle\ApiGatewayBundle::class => ['all' => true]    
];

```

add to config/routes.yml
```yaml
api_gateway:
  resource: '@ApiGatewayBundle/Resources/config/routes.xml'
```

## Config

### Config endpoints

in  api_gateway.yml
```yaml
api_gateway:
  config:
    headers:
      - 'Content-Type'
  endpoints:
    api_example:
      url: '/api/example'
      method: 'POST'
      config:
        url: 'https://example.com/api/example'
        method: 'POST'

```
### Load endpoint from loader

- You create a service that implements the [EndpointLoaderInterface](src/Contracts/EndpointLoaderInterface.php) interface
- You add tag `api_gateway.endpoint_loader` for this service

```php
<?php
namespace App\Routing;

use Demroos\Bundle\ApiGatewayBundle\Contracts\EndpointLoaderInterface;
use Demroos\Bundle\ApiGatewayBundle\Endpoint;

class ExampleEndpointLoader implements EndpointLoaderInterface
{
    public function load(): array
    {
        $endpoints = [];

        $endpoint = new Endpoint(
            'api_example',
            '/api/example',
            'POST'
        );

        $endpoints[] = $endpoint;

        return $endpoints;
    }
}
```

in config/services.yaml
```yaml
services:
  App\Routing\ExampleEndpointLoader:
    tags: [api_gateway.endpoint_loader]
```

### Config client factory

in  api_gateway.yml
```yaml
api_gateway:
  client_factory:
    #service: id_service_for_use_as_client_factory
    config:
      http_errors: false
```

### Support PHP

| ApiGatewayBundle |  PHP  | Symfony      |
|------------------|-------|--------------|
| [0.1] (develop)  | >=7.4 |  ^4.3\|^5.0  |
| [0.0] (0.0)      | ^7.3  |  ^4.3\|^5.0  |
