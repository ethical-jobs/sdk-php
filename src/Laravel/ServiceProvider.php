<?php

namespace EthicalJobs\SDK\Laravel;

use EthicalJobs\SDK\Mappers\TaxonomyMapper;
use GuzzleHttp;
use Illuminate\Contracts\Cache\Repository;
use EthicalJobs\SDK\Authentication;
use EthicalJobs\SDK\HttpClient;
use EthicalJobs\SDK\ApiClient;
use EthicalJobs\SDK\Mappers;

/**
 * Laravel application service provider
 *
 * @author Andrew McLagan <andrew@ethicaljobs.com.au>
 */

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register any other events for your application.
     *
     * @return void
     */
    public function boot() {}

    /**
     * Bind Repository interfaces to their appropriate implementations.
     *
     * @return void
     */
    public function register()
    {
        $this->bindGuzzle();

        $this->bindAuthenticator();

        $this->bindHttpClient();

        $this->bindApiClient();
    }

    /**
     * Bind guzzle client
     *
     * @return  Void
     */
    public function bindGuzzle()
    {
        // Bind guzzle into the container for testing.
        $this->app->bind(GuzzleHttp\Client::class, function ($app) {
            return new GuzzleHttp\Client(['verify' => false]); // Disable SSL cert verification.
        });        
    }

    /**
     * Bind authenticator
     *
     * @return  Void
     */
    public function bindAuthenticator()
    {    
        $credentials = [
            'client_id'     => env('AUTH_CLIENT_ID'),
            'client_secret' => env('AUTH_CLIENT_SECRET'),
            'username'      => env('AUTH_SERVICE_USERNAME'),
            'password'      => env('AUTH_SERVICE_PASSWORD'),            
        ];

        $this->app->bind(Authentication\Authenticator::class, function ($app) use ($credentials) {
            $client = $app->make(GuzzleHttp\Client::class);
            $cache = $app->make(Repository::class);
            return new Authentication\TokenAuthenticator($client, $cache, $credentials);
        });
    }

    /**
     * Bind http client
     *
     * @return  Void
     */
    public function bindHttpClient()
    { 
        $this->app->bind(HttpClient::class, function ($app) {
            $client = $app->make(GuzzleHttp\Client::class);
            $auth = $app->make(Authentication\Authenticator::class);
            return new HttpClient($client, $auth);
        });
    }

    /**
     * Bind api client
     *
     * @return  Void
     */
    public function bindApiClient()
    {
        $this->app->singleton(ApiClient::class, function ($app) {
            $http = $app->make(HttpClient::class);
            return new ApiClient($http);
        });
    }

    /**
     * Bind api client
     *
     * @return  Void
     */
    public function bindTaxonomyMapper()
    {
        $this->app->bind(TaxonomyMapper::class, function ($app) {
            $api = $app->make(ApiClient::class);
            return new TaxonomyMapper($api);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            GuzzleHttp\Client::class,
            Authentication\Authenticator::class,
            HttpClient::class,
            ApiClient::class,
            Mappers\TaxonomyMapper::class,
        ];
    }        
}