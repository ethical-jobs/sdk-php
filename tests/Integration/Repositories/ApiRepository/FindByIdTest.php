<?php

namespace Tests\Integration\Repositories\ApiRepository;

use EthicalJobs\SDK\ApiClient;
use EthicalJobs\SDK\Collection;
use EthicalJobs\SDK\Repositories\ApiRepository;
use Mockery;
use Tests\TestCase;

class FindByIdTest extends TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_can_find_by_id()
    {
        $expected = new Collection(['entities' => 'jobs']);

        $api = Mockery::mock(ApiClient::class)
            ->shouldReceive('get')
            ->with("/jobs/1337")
            ->andReturn($expected)
            ->getMock();

        $repository = new ApiRepository($api, 'jobs');

        $response = $repository->findById(1337);

        $this->assertEquals($response, $expected);
    }
}
