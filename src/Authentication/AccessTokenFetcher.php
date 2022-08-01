<?php

declare(strict_types=1);

namespace EthicalJobs\SDK\Authentication;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;
use EthicalJobs\SDK\Router;

class AccessTokenFetcher
{

    /**
     * Guzzle client
     *
     * @var Client
     */
    protected $client;

    /**
     * Http credentials
     *
     * @var array{client_id: string, client_secret: string, username: string, password: string}
     */
    protected $credentials = [
        'client_id' => '',
        'client_secret' => '',
        'username' => '',
        'password' => '',
    ];

    /**
     * @param \GuzzleHttp\Client $client
     * @param array{client_id: string, client_secret: string, username: string, password: string} $credentials
     */
    public function __construct(Client $client, array $credentials = [])
    {
        $this->client = $client;

        $this->credentials = $credentials;
    }

    /**
     * Fetches an Auth token
     *
     * @return string
     * @throws GuzzleException
     */
    public function fetchToken(): string
    {
        $route = Router::getRouteUrl('/oauth/token');

        $json = array_merge([
            'grant_type' => 'password',
            'scope' => '*',
        ], $this->credentials);

        $response = $this->tokenRequest($route, $json);

        if ($response->getStatusCode() > 199 && $response->getStatusCode() < 300) {
            if ($decoded = json_decode((string)$response->getBody())) {
                return $decoded->access_token ?? '';
            }
        }

        return '';
    }

    /**
     * Fetches an Auth token
     *
     * @return Response
     * @throws ClientException
     * @throws GuzzleException
     */
    protected function tokenRequest(string $route, array $params): Response
    {
        try {
            return $this->client->request('POST', $route, ['json' => $params]);
        } catch (ClientException $exception) {
            if (in_array($exception->getResponse()->getStatusCode(), [401, 403])) {
                throw new ClientException(
                    'Unauthorized SDK Request',
                    $exception->getRequest(),
                    $exception->getResponse(),
                    null,
                    $exception->getHandlerContext()
                );
            }
            throw $exception;
        }
    }

}
