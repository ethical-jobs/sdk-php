<?php

namespace EthicalJobs\SDK\Authentication;

use EthicalJobs\SDK\Router;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Illuminate\Contracts\Cache\Repository;

/**
 * Token Authenticator
 *
 * @author Andrew McLagan <andrew@ethicaljobs.com.au>
 */
class TokenAuthenticator implements Authenticator
{
    /**
     * Auth token cache key
     *
     * @var string
     */
    protected $tokenKey = 'ej:pkg:sdk:token';

    /**
     * Auth token cache lifespan (minutes)
     *
     * @var string
     */
    protected $tokenTTL = 1080; // refresh the token once a week

    /**
     * Guzzle client
     *
     * @var Client
     */
    protected $client;

    /**
     * Cache instance
     *
     * @var Repository
     */
    protected $cache;

    /**
     * Http credentials
     *
     * @var array
     */
    protected $credentials = [
        'client_id' => '',
        'client_secret' => '',
        'username' => '',
        'password' => '',
    ];

    /**
     * Object constructor
     *
     * @param Client $client
     * @param Repository $cache
     * @param array $credentials
     */
    public function __construct(Client $client, Repository $cache, Array $credentials = [])
    {
        $this->client = $client;

        $this->cache = $cache;

        $this->setCredentials($credentials);
    }

    /**
     * Sets credentials
     *
     * @param array $credentials
     * @return $this
     */
    public function setCredentials(array $credentials): Authenticator
    {
        $this->credentials = $credentials;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function authenticate(Request $request)
    {
        $token = $this->getToken();

        return $request->withAddedHeader('Authorization', "Bearer $token");
    }

    /**
     * Gets the token
     *
     * @return string
     */
    public function getToken(): string
    {
        return $this->cache->remember($this->tokenKey, $this->tokenTTL, function () {
            return $this->fetchToken();
        });
    }

    /**
     * Fetches an Auth token
     *
     * @return string
     * @throws GuzzleException
     */
    protected function fetchToken(): string
    {
        $route = Router::getRouteUrl('/oauth/token');

        $json = array_merge([
            'grant_type' => 'password',
            'scope' => '*',
        ], $this->credentials);

        $response = $this->tokenRequest($route, $json);

        if ($response->getStatusCode() > 199 && $response->getStatusCode() < 300) {
            if ($decoded = json_decode($response->getBody())) {
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