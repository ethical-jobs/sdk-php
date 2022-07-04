<?php

declare(strict_types=1);

namespace EthicalJobs\SDK;

use EthicalJobs\SDK\Authentication\Authenticator;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;

/**
 * Http client
 *
 * @author Andrew McLagan <andrew@ethicaljobs.com.au>
 */
class HttpClient
{
    protected bool $authenticate = false;
    protected Request $request;
    protected Response $response;

    public function __construct(protected Client $client, protected ?Authenticator $authenticator = null)
    {
    }

    /**
     * Set authentication to true
     *
     * @return HttpClient
     */
    public function authenticate(): HttpClient
    {
        $this->authenticate = true;

        return $this;
    }

    /**
     * Http get request
     *
     * @param string $route
     * @param array $body
     * @param array $headers
     * @return Collection
     * @throws GuzzleException
     */
    public function get(string $route, $body = [], $headers = [])
    {
        return $this->request('GET', $route, $body, $headers);
    }

    /**
     * Makes a http request
     *
     * @param string $verb
     * @param string $route
     * @param array $body
     * @param array $headers
     * @return Collection
     * @throws GuzzleException
     */
    public function request(string $verb, string $route, $body = [], $headers = []): Collection
    {
        $request = $this->createRequest($verb, $route, $body, $headers);

        $request = $this->authenticateRequest($request);

        $collection = $this->handleRequest($request);

        return $collection;
    }

    /**
     * Creates and sets the request instance
     *
     * @param string $verb
     * @param string $route
     * @param array $body
     * @param array $headers
     * @return Request
     */
    protected function createRequest(string $verb, string $route, $body = [], $headers = [])
    {
        $url = Router::getRouteUrl($route);

        if (strtoupper($verb) === 'GET') {
            $url .= '?' . http_build_query($body);
        }

        $request = new Request($verb, $url, $this->mergeDefaultHeaders($headers), json_encode($body));

        $this->setRequest($request);

        return $request;
    }

    /**
     * Merges degfault headers with user defined headers
     *
     * @param array $headers
     * @return array
     */
    protected function mergeDefaultHeaders(array $headers = [])
    {
        return array_merge([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ], $headers);
    }

    /**
     * Gets the request authenticator
     *
     * @param Request $request
     * @return Request
     */
    protected function authenticateRequest(Request $request)
    {
        if ($this->authenticator && $this->authenticate) {
            return $this->authenticator->authenticate($request);
        }

        return $request;
    }

    /**
     * Handles expired access token case by fetching new one and subsequently replays original request
     *
     * @param Request $request
     * @return Collection
     * @throws GuzzleException
     */
    protected function handleRequest(Request $request): Collection
    {
        try {
            return $this->dispatchRequest($request);
        } catch (ClientException $exception) {

            $this->response = $exception->getResponse();

            if (
                $this->authenticate &&
                ($this->response->getStatusCode() === 401 || $this->response->getStatusCode() === 403)
            ) {
                $this->authenticator->reset();
                $request = $this->authenticateRequest($request);
                return $this->dispatchRequest($request);
            }

            throw $exception;
        }
    }

    /**
     * Dispatches a request and returns a response instance
     *
     * @param Request $request
     * @return Collection
     * @throws GuzzleException
     */
    protected function dispatchRequest(Request $request): Collection
    {
        try {
            $response = $this->client->send($request);

            $this->response = $response;

            return $this->parseResponse($response);
        } catch (ClientException $exception) {
            $this->response = $exception->getResponse();

            if ($this->response->getStatusCode() === 404) {
                return new Collection;
            }

            throw $exception;
        }
    }

    /**
     * Prases a response and returns a collection or item
     *
     * @param Response $response
     * @return Collection
     */
    protected function parseResponse(Response $response)
    {
        $status = $response->getStatusCode();
        if ($status > 199 && $status < 299) {
            if ($body = json_decode($response->getBody()->getContents(), true)) {
                return new Collection($body);
            }
        }

        return new Collection;
    }

    /**
     * Http post request
     *
     * @param string $route
     * @param array $body
     * @param array $headers
     * @return Collection
     * @throws GuzzleException
     */
    public function post(string $route, $body = [], $headers = [])
    {
        return $this->request('POST', $route, $body, $headers);
    }

    /**
     * Http put request
     *
     * @param string $route
     * @param array $body
     * @param array $headers
     * @return Collection
     * @throws GuzzleException
     */
    public function put(string $route, $body = [], $headers = [])
    {
        return $this->request('PUT', $route, $body, $headers);
    }

    /**
     * Http patch request
     *
     * @param string $route
     * @param array $body
     * @param array $headers
     * @return Collection
     * @throws GuzzleException
     */
    public function patch(string $route, $body = [], $headers = [])
    {
        return $this->request('PATCH', $route, $body, $headers);
    }

    /**
     * Http delete request
     *
     * @param string $route
     * @param array $body
     * @param array $headers
     * @return Collection
     * @throws GuzzleException
     */
    public function delete(string $route, $body = [], $headers = [])
    {
        return $this->request('DELETE', $route, $body, $headers);
    }

    /**
     * Gets the current request instance
     *
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Sets the current request instance
     *
     * @param Request $request
     * @return $this
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;

        return $this;
    }

    /**
     * Gets the current response instance
     *
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }
}
