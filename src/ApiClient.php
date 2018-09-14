<?php

namespace EthicalJobs\SDK;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\MockHandler;
use Illuminate\Support\Facades\Cache;
use EthicalJobs\Storage\Contracts\Repository;
use EthicalJobs\SDK\Testing\ResponseFactory;
use EthicalJobs\SDK\Router;

/**
 * EthicalJobs api client
 *
 * @author Andrew McLagan <andrew@ethicaljobs.com.au>
 */

class ApiClient 
{
	/**
	 * Http client
	 *
	 * @var \EthicalJobs\SDK\HttpClient
	 */
	protected $http;

	/**
	 * Resource collection
	 *
	 * @var \EthicalJobs\SDK\ResourceCollection
	 */
	protected $resources;


	/**
	 * Object constructor
	 *
	 * @return  Void
	 */
	public function __construct(HttpClient $http)
	{
		$this->http = $http;

		$this->resources = new ResourceCollection;
	}

	/**
	 * Resource repository accessor
	 * 
	 * @param string $resourceName
	 * @return EthicalJobs\Storage\Contracts\Repository
	 */
   	public function resource(string $resourceName): Repository
   	{	
   		if ($resource = $this->resources->get($resourceName)) {
   			return ResourceCollection::makeResourceRepository($resource);
   		}

   		throw new \Exception("Invalid api resource repository '{$resourceName}'");
   	}

	/**
	 * Retrieves app-data from `api.ethicaljobs.com.au/` base route
	 * 
	 * @return EthicalJobs\SDK\Collection
	 */
   	public function appData()
   	{
        return Cache::remember('ej:sdk:app-data', 120, function(){
            return $this->http->get('/');
        });		
   	}	   	

	/**
	 * Dynamic api resource properties
	 * 
	 * @param string $resourceName
	 * @return EthicalJobs\Foundation\Storage\Repository
	 */
   	public function __get(string $resourceName)
   	{
   		return $this->resource($resourceName);
   	}	

   	/**
   	 * Dynamic http verb methods
   	 * 
   	 * @param  String $name
   	 * @param  Array $arguments
   	 * @return Mixed
   	 */
    public function __call($name, $arguments)
    {
    	if (method_exists($this->http, $name)) {
    		return $this->http->$name(...$arguments);
    	}
        
        throw new \Exception("Invalid http call '{$name}'");
	}   	
	
    /**
     * Mocks a response stack into the api client
     *
	 * @param array $stack
     * @return ApiClient
     */
    public static function mock(array $stack = []) : ApiClient
    {
        $mock = new MockHandler($stack);
        
        $handler = HandlerStack::create($mock);

		$client = new Client(['handler' => $handler, 'verify' => false]);

		app()->instance('ej:sdk:guzzle', $client);	

		return resolve(__CLASS__);
    }  		
}