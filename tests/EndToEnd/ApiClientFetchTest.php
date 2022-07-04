<?php

declare(strict_types=1);

namespace Tests\EndToEnd;

use EthicalJobs\SDK\ApiClient;
use EthicalJobs\SDK\Collection;
use EthicalJobs\SDK\Testing\ResponseFactory;
use Illuminate\Support\Arr;
use Tests\TestCase;

class ApiClientFetchTest extends TestCase
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
            'status' => 'APPROVED',
            'limit' => 10,
        ]);

        $this->assertInstanceOf(Collection::class, $results);

        $this->assertTrue(Arr::has($results, 'data.entities.jobs'));
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

        $this->assertTrue(Arr::has($results, 'data.entities.jobs'));
    }
}
