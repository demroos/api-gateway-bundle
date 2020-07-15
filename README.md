# ApiGatewayBundle

## Install
`composer require demroos/api-gateway-bundle`

### Enable bundle

```php
<?php

return [
    // other bundles,                            
    Demroos\Bundle\ApiGatewayBundle\ApiGatewayBundle::class => ['all' => true]    
];

```

## Features

* Getting endpoints from bundle configuration
* Getting endpoints from loaders, see [EndpointLoaderInterface](src/Contracts/EndpointLoaderInterface.php)
* Feature for processing body request/response is coming soon

## Config api_gateway.yml

### Config endpoints
```yaml
api_gateway:
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

```yaml
services:
  App\Routing\ExampleEndpointLoader:
    tags: [api_gateway.endpoint_loader]
```
