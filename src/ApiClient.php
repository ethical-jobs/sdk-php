<?php

declare(strict_types=1);

namespace EthicalJobs\SDK;

use EthicalJobs\SDK\Storage\Contracts\Repository;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Cache;

/**
 * EthicalJobs api client
 *
 * @author Andrew McLagan <andrew@ethicaljobs.com.au>
 * @method authenticate(): HttpClient
 * @method get(string $route, $body = [], $headers = [])
 * @method request(string $verb, string $route, $body = [], $headers = []): Collection
 * @method post(string $route, $body = [], $headers = [])
 * @method put(string $route, $body = [], $headers = [])
 * @method patch(string $route, $body = [], $headers = [])
 * @method delete(string $route, $body = [], $headers = [])
 * @method getRequest()
 * @method setRequest(Request $request)
 * @method getResponse()
 */
class ApiClient
{
    /**
     * Http client
     *
     * @var HttpClient
     */
    protected $http;

    /**
     * Resource collection
     *
     * @var ResourceCollection
     */
    protected $resources;


    /**
     * Object constructor
     *
     * @param HttpClient $http
     */
    public function __construct(HttpClient $http)
    {
        $this->http = $http;

        $this->resources = new ResourceCollection;
    }

    /**
     * Mocks a response stack into the api client
     *
     * @param array $stack
     * @return ApiClient
     */
    public static function mock(array $stack = []): ApiClient
    {
        $mock = new MockHandler($stack);

        $handler = HandlerStack::create($mock);

        $client = new Client(['handler' => $handler, 'verify' => false]);

        app()->instance('ej:sdk:guzzle', $client);

        return resolve(__CLASS__);
    }

    /**
     * Retrieves app-data from `api.ethicaljobs.com.au/` base route
     *
     * @return Collection
     */
    public function appData()
    {
        return Cache::remember('ej:sdk:app-data', 120, function () {
            return $this->http->get('/');
        });
    }

    /**
     * Dynamic api resource properties
     *
     * @param string $resourceName
     * @return Repository
     * @throws Exception
     */
    public function __get(string $resourceName)
    {
        return $this->resource($resourceName);
    }

    /**
     * Resource repository accessor
     *
     * @param string $resourceName
     * @return Repository
     * @throws Exception
     */
    public function resource(string $resourceName): Repository
    {
        if ($resource = $this->resources->get($resourceName)) {
            return ResourceCollection::makeResourceRepository($resource);
        }

        throw new Exception("Invalid api resource repository '{$resourceName}'");
    }

    /**
     * Dynamic http verb methods
     *
     * @param String $name
     * @param array $arguments
     * @return Mixed
     * @throws Exception
     */
    public function __call($name, $arguments)
    {
        if (method_exists($this->http, $name)) {
            return $this->http->$name(...$arguments);
        }

        throw new Exception("Invalid http call '{$name}'");
    }
}
