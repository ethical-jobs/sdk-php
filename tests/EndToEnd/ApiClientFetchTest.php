<?php

namespace Tests\EndToEnd;

use Illuminate\Support\Facades\App;
use EthicalJobs\SDK\Collection;
use EthicalJobs\SDK\ApiClient;
use Tests\Fixtures\ResponseFactory;
use Tests\Fixtures\MockResponseStack;

class ApiClientFetchTest extends \Tests\TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_can_fetch_unprotected_routes()
    {
        MockResponseStack::mock([
            ResponseFactory::response(200, ResponseFactory::authentication()),
            ResponseFactory::response(200, ResponseFactory::jobs()),
        ]);

        $apiClient = App::make(ApiClient::class);

        $results = $apiClient->get('/jobs', [
            'status'    => 'APPROVED',
            'limit'     => 10,
        ]);

        $this->assertInstanceOf(Collection::class, $results);
        
        $this->assertTrue(array_has($results->toArray(), 'data.entities.jobs'));
    }
}
