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
* Feature for processing body request/response is commin soon
