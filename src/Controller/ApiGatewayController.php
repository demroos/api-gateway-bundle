<?php
/**
 * Created by PhpStorm.
 * @author Ewgeniy Kiselev <demroos@gmail.com>
 * Date: 11.07.2020
 * Time: 15:33
 */

namespace Demroos\Bundle\ApiGatewayBundle\Controller;

use Demroos\Bundle\ApiGatewayBundle\EndpointRegistry;
use Demroos\Bundle\ApiGatewayBundle\Event\EndpointRequestEvent;
use Demroos\Bundle\ApiGatewayBundle\Event\EndpointResponseEvent;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiGatewayController
{
    /**
     * @var EndpointRegistry
     */
    private EndpointRegistry $endpointRegistry;

    /**
     * @var ClientInterface
     */
    private ClientInterface $client;

    /**
     * @var EventDispatcherInterface
     */
    private EventDispatcherInterface $dispatcher;

    private array $config;

    /**
     * ApiGatewayController constructor.
     * @param EndpointRegistry $endpointRegistry
     * @param ClientInterface $client
     * @param EventDispatcherInterface $dispatcher
     * @param array $config
     */
    public function __construct(EndpointRegistry $endpointRegistry, ClientInterface $client, EventDispatcherInterface $dispatcher, array $config)
    {
        $this->endpointRegistry = $endpointRegistry;
        $this->client = $client;
        $this->dispatcher = $dispatcher;
        $this->config = $config;
    }


    /**
     * @param Request $request
     * @return Response
     * @throws GuzzleException
     */
    public function singleRequest(Request $request)
    {
        $endpoint = $this->endpointRegistry->get($request->get('_route'));
        $route = $endpoint->getConfig();

        // transform
        $body = $request->getContent();
        $requestData = json_decode($body, true);

        $event = new EndpointRequestEvent($endpoint, $requestData);
        $this->dispatcher->dispatch($event, EndpointRequestEvent::NAME);
        $requestData = $event->getRequest();

        if (isset($route['transform']) && isset($route['transform']['request'])) {
            $bodyData = $this->processRequest($requestData, $route['transform']['request']);
            $body = json_encode($bodyData);
        }

        $response = $this->client->request($route['method'], $route['url'], ['body' => $body]);
        $headers = $this->getHeaders($response, $this->config['headers']);

        $responseData = json_decode($response->getBody(), true);
        $event = new EndpointResponseEvent($endpoint, $responseData);
        $this->dispatcher->dispatch($event, EndpointResponseEvent::NAME);
        $responseData = $event->getResponse();

        return new JsonResponse($responseData, $response->getStatusCode(), $headers);
    }

    private function getHeaders(ResponseInterface $response, array $names = []): array
    {
        $headers = [];
        foreach ($names as $headerName) {
            if ($response->hasHeader($headerName)) {
                $headers[$headerName] = $response->getHeader($headerName);
            }
        }
        return $headers;
    }

    private function processRequest($data, $config)
    {
        if ($config['wrap']) {
            $newData = [];
            $newData[$config['wrap']['key']] = $data;
            $data = $newData;
        }

        return $data;
    }
}
