<?php

namespace Tests\EndToEnd;

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
        $api = ApiClient::mock([
            ResponseFactory::response(200, ResponseFactory::jobs()),
        ]);

        $results = $api->get('/jobs', [
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
        $api = ApiClient::mock([
            ResponseFactory::response(200, ResponseFactory::authentication()),
            ResponseFactory::response(200, ResponseFactory::jobs()),
        ]);        

        $results = $api
            ->authenticate()
            ->post('/jobs', [
                'title' => 'Hello World!',
            ]);

        $this->assertInstanceOf(Collection::class, $results);

        $this->assertTrue(array_has($results, 'data.entities.jobs'));
    }    
}
