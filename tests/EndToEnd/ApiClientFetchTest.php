<?php

namespace Tests\EndToEnd;

use GuzzleHttp\Client;
use GuzzleHttp\Middleware;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\MockHandler;
use Illuminate\Support\Facades\App;
use Illuminate\Contracts\Cache\Repository;
use EthicalJobs\SDK\Authentication\TokenAuthenticator;
use EthicalJobs\SDK\Collection;
use EthicalJobs\SDK\HttpClient;
use EthicalJobs\SDK\ApiClient;
use EthicalJobs\SDK\Testing\ResponseFactory;

class ApiClientFetchTest extends \Tests\TestCase
{
    /**
     * @test
     */
    public function it_can_fetch_unprotected_routes()
    {
        $responseStack = new MockHandler([
            ResponseFactory::response(200, ResponseFactory::jobs()),
        ]);

        $guzzle = new Client(['handler' => HandlerStack::create($responseStack)]);            

        App::instance(Client::class, $guzzle);

        $apiClient = App::make(ApiClient::class);

        $results = $apiClient->get('/jobs', [
            'status'    => 'APPROVED',
            'limit'     => 10,
        ]);

        $this->assertInstanceOf(Collection::class, $results);
        
        $this->assertTrue(array_has($results, 'data.entities.jobs'));
    }

    /**
     * @test
     */
    public function it_can_fetch_protected_routes()
    {
        $responseStack = new MockHandler([
            ResponseFactory::response(200, ResponseFactory::authentication()),
            ResponseFactory::response(200, ResponseFactory::jobs()),
        ]);

        $guzzle = new Client(['handler' => HandlerStack::create($responseStack)]);

        App::instance(Client::class, $guzzle);

        $apiClient = App::make(ApiClient::class);

        $results = $apiClient
            ->authenticate()
            ->get('/jobs', [
                'status' => 'APPROVED',
                'limit' => 10,
            ]);

        $this->assertInstanceOf(Collection::class, $results);

        $this->assertTrue(array_has($results, 'data.entities.jobs'));
    }    
}
