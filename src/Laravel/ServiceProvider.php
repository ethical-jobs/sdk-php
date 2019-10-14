<?php

namespace EthicalJobs\SDK\Laravel;

use EthicalJobs\SDK\ApiClient;
use EthicalJobs\SDK\Authentication;
use EthicalJobs\SDK\HttpClient;
use EthicalJobs\SDK\Mappers;
use EthicalJobs\SDK\Mappers\TaxonomyMapper;
use GuzzleHttp;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Contracts\Foundation\Application;

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
    public function boot()
    {
    }

    /**
     * Bind Repository interfaces to their appropriate implementations.
     *
     * @return void
     */
    public function register()
    {
        $this->bindGuzzle();

        $this->bindAuth();

        $this->bindHttpClient();

        $this->bindApiClient();

        $this->bindTaxonomyMapper();
    }

    /**
     * Bind guzzle client
     * - Unique instance of guzzle
     * - Enables us to mock without effecting other uses of guzzle
     *
     * @return void
     * @todo Verify SSL certificates
     */
    public function bindGuzzle()
    {
        $this->app->bind('ej:sdk:guzzle', function () {
            return new GuzzleHttp\Client(['verify' => false]); // Disable SSL cert verification.
        });
    }

    /**
     * Bind authenticator
     *
     * @return void
     */
    public function bindAuth()
    {
        $credentials = [
            'client_id' => env('AUTH_CLIENT_ID'),
            'client_secret' => env('AUTH_CLIENT_SECRET'),
            'username' => env('AUTH_SERVICE_USERNAME'),
            'password' => env('AUTH_SERVICE_PASSWORD'),
        ];

        $this->app->bind(Authentication\AccessTokenFetcher::class, function (Application $app) use ($credentials) {
            $client = $app->make('ej:sdk:guzzle');

            return new Authentication\AccessTokenFetcher($client, $credentials);
        });

        // Bind token authenticator with its dependencies
        $this->app->bind(Authentication\TokenAuthenticator::class, function (Application $app) use ($credentials) {
            $accessTokenFetcher = $app->make(Authentication\AccessTokenFetcher::class);
            $cache = $app->make(Repository::class);

            return new Authentication\TokenAuthenticator($accessTokenFetcher, $cache);
        });

        // Bind Authenticator contract to token auth as default implementation
        $this->app->bind(Authentication\Authenticator::class, function (Application $app) use ($credentials) {
            return $app->make(Authentication\TokenAuthenticator::class);
        });
    }

    /**
     * Bind http client
     *
     * @return void
     */
    public function bindHttpClient()
    {
        $this->app->bind(HttpClient::class, function (Application $app) {
            $client = $app->make('ej:sdk:guzzle');
            $auth = $app->make(Authentication\Authenticator::class);

            return new HttpClient($client, $auth);
        });
    }

    /**
     * Bind api client
     *
     * @return void
     */
    public function bindApiClient()
    {
        $this->app->singleton(ApiClient::class, function (Application $app) {
            $http = $app->make(HttpClient::class);

            return new ApiClient($http);
        });
    }

    /**
     * Bind api client
     *
     * @return void
     */
    public function bindTaxonomyMapper()
    {
        $this->app->bind(TaxonomyMapper::class, function (Application $app) {
            $api = $app->make(ApiClient::class);

            return new TaxonomyMapper($api);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(): array
    {
        return [
            'ej:sdk:guzzle',
            Authentication\AccessTokenFetcher::class,
            Authentication\TokenAuthenticator::class,
            Authentication\Authenticator::class,
            Mappers\TaxonomyMapper::class,
            HttpClient::class,
            ApiClient::class,
        ];
    }
}