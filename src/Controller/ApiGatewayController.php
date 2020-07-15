<?php
/**
 * Created by PhpStorm.
 * @author Ewgeniy Kiselev <demroos@gmail.com>
 * Date: 11.07.2020
 * Time: 15:33
 */

namespace Demroos\Bundle\ApiGatewayBundle\Controller;

use Demroos\Bundle\ApiGatewayBundle\EndpointRegistry;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiGatewayController
{
    /**
     * @var EndpointRegistry
     */
    private EndpointRegistry $endpointRegistry;

    /**
     * ApiGatewayController constructor.
     * @param EndpointRegistry $endpointRegistry
     */
    public function __construct(EndpointRegistry $endpointRegistry)
    {
        $this->endpointRegistry = $endpointRegistry;
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
        $client = new Client(['http_errors' => false]);

        // transform
        $body = $request->getContent();
        if (isset($route['transform']) && isset($route['transform']['request'])) {
            $bodyData = $this->processRequest(json_decode($body), $route['transform']['request']);
            $body = json_encode($bodyData);
        }

        $response = $client->request($route['method'], $route['url'], ['body' => $body]);
        $headers = $this->getHeaders($response, ['Content-Type', 'Content-Length']);
        return new Response($response->getBody(), $response->getStatusCode(), $headers);
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
