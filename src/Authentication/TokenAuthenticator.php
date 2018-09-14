<?php

namespace EthicalJobs\SDK\Authentication;

use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Contracts\Cache\Repository;
use EthicalJobs\SDK\Router;

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
	 * @var \GuzzleHttp\Client
	 */
	protected $client;

	/**
	 * Cache instance
	 *
	 * @var \Illuminate\Contracts\Cache\Repository
	 */
	protected $cache;	

	/**
	 * Http credentials
	 *
	 * @var Arary
	 */
	protected $credentials = [
    	'client_id' 	=> '',
    	'client_secret' => '',		
    	'username' 		=> '',	
    	'password' 		=> '',	
	];	

	/**
	 * Object constructor
	 *
	 * @param 
	 */
	public function __construct(Client $client, Repository $cache, Array $credentials = [])
	{
		$this->client = $client;

		$this->cache = $cache;

		$this->setCredentials($credentials);
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
	public function getToken() : string
	{
		return $this->cache->remember($this->tokenKey, $this->tokenTTL, function () {
		    return $this->fetchToken();
		});
	}	

	/**
	 * Sets credentials
	 *
	 * @param array $credentials
	 * @return $this
	 */
	public function setCredentials(array $credentials) : Authenticator
	{
		$this->credentials = $credentials;

		return $this;
	}


	/**
	 * Fetches an Auth token
	 * 
	 * @return string 
	 */
	protected function fetchToken() : string
	{	
		$route = Router::getRouteUrl('/oauth/token');

		$json = array_merge([
        	'grant_type' 	=> 'password',
        	'scope' 		=> '*',			
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
	 * @throws ClientException
	 * @return Response
	 */
	protected function tokenRequest(string $route, array $params) : Response
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