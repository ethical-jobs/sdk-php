<?php

namespace Tests\Integration\Repositories\ApiRepository;

use EthicalJobs\SDK\ApiClient;
use EthicalJobs\SDK\Collection;
use EthicalJobs\SDK\Repositories\ApiRepository;
use Mockery;
use Tests\TestCase;

class WhereHasInTest extends TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_has_fluent_interface()
    {
        $api = Mockery::mock(ApiClient::class);

        $repository = new ApiRepository($api);

        $isFluent = $repository->whereHasIn('categories.id', [22, 33, 44]);

        $this->assertInstanceOf(ApiRepository::class, $isFluent);
    }

    /**
     * @test
     * @group Unit
     */
    public function it_never_adds_whereHasIn_query_params()
    {
        $expected = new Collection(['entities' => 'jobs']);

        $api = Mockery::mock(ApiClient::class)
            ->shouldReceive('get')
            ->once()
            ->with('/invoices', [])
            ->andReturn($expected)
            ->getMock();

        $repository = new ApiRepository($api, 'invoices');

        $repository
            ->whereHasIn('categories.id', [22, 33, 44])
            ->find();
    }
}
