<?php

declare(strict_types=1);

namespace Tests\Integration\Repositories\ApiRepository;

use EthicalJobs\SDK\ApiClient;
use EthicalJobs\SDK\Collection;
use EthicalJobs\SDK\Repositories\ApiRepository;
use Mockery;
use Tests\TestCase;

class FindTest extends TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_can_execute_the_query()
    {
        $expected = new Collection(['entities' => 'jobs']);

        $api = Mockery::mock(ApiClient::class)
            ->shouldReceive('get')
            ->with('/search/jobs', [])
            ->andReturn($expected)
            ->getMock();

        $repository = new ApiRepository($api, 'search/jobs');

        $response = $repository->find();

        $this->assertEquals($response, $expected);
    }
}
