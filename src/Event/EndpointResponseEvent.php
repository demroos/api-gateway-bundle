<?php
/**
 * Created by PhpStorm.
 * @author Ewgeniy Kiselev <demroos@gmail.com>
 * Date: 25.03.2021
 * Time: 16:05
 */

namespace Demroos\Bundle\ApiGatewayBundle\Event;

use Demroos\Bundle\ApiGatewayBundle\Endpoint;
use Symfony\Contracts\EventDispatcher\Event;

class EndpointResponseEvent extends Event
{
    public const NAME = 'api_gateway.endpoint.response';

    /**
     * @var Endpoint
     */
    private Endpoint $endpoint;

    private array $response;

    /**
     * EndpointResponseEvent constructor.
     * @param Endpoint $endpoint
     * @param array $response
     */
    public function __construct(Endpoint $endpoint, array $response)
    {
        $this->endpoint = $endpoint;
        $this->response = $response;
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
    public function getResponse(): array
    {
        return $this->response;
    }

    /**
     * @param array $response
     */
    public function setResponse(array $response): void
    {
        $this->response = $response;
    }
}
