<?php

declare(strict_types=1);

namespace Tests\Integration\Repositories\ApiRepository;

use EthicalJobs\SDK\ApiClient;
use EthicalJobs\SDK\Collection;
use EthicalJobs\SDK\Repositories\ApiRepository;
use Mockery;
use Tests\TestCase;

class FindByFieldTest extends TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_can_find_by_a_field()
    {
        $expected = new Collection(['entities' => 'jobs']);

        $api = Mockery::mock(ApiClient::class)
            ->shouldReceive('get')
            ->with('/jobs', [
                'limit' => 1,
                'status' => 'APPROVED',
            ])
            ->andReturn($expected)
            ->getMock();

        $repository = new ApiRepository($api, 'jobs');

        $response = $repository->findByField('status', 'APPROVED');

        $this->assertEquals($response, $expected);
    }
}
