<?php
/**
 * Created by PhpStorm.
 * @author Ewgeniy Kiselev <demroos@gmail.com>
 * Date: 25.03.2021
 * Time: 15:54
 */

namespace Demroos\Bundle\ApiGatewayBundle\Event;

use Demroos\Bundle\ApiGatewayBundle\Endpoint;
use Symfony\Contracts\EventDispatcher\Event;

class EndpointRequestEvent extends Event
{
    public const NAME = 'api_gateway.endpoint.request';

    /**
     * @var Endpoint
     */
    private $endpoint;

    private array $request;

    /**
     * EndpointRequestEvent constructor.
     * @param Endpoint $endpoint
     * @param array $request
     */
    public function __construct(Endpoint $endpoint, array $request)
    {
        $this->endpoint = $endpoint;
        $this->request = $request;
    }

    /**
     * @return Endpoint
     */
    public function getEndpoint(): Endpoint
    {
        return $this->endpoint;
    }

    /**
     * @return array
     */
    public function getRequest(): array
    {
        return $this->request;
    }

    /**
     * @param array $request
     */
    public function setRequest(array $request): void
    {
        $this->request = $request;
    }
}
