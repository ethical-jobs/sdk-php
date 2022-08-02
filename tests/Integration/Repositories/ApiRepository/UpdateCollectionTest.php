<?php

declare(strict_types=1);

namespace Tests\Integration\Repositories\ApiRepository;

use EthicalJobs\SDK\ApiClient;
use EthicalJobs\SDK\Collection;
use EthicalJobs\SDK\Repositories\ApiRepository;
use Mockery;
use Tests\TestCase;

class UpdateCollectionTest extends TestCase
{
    /**
     * @test
     * @group Integration
     */
    public function it_chunks_collection_when_updating()
    {
        $jobs = new Collection;

        for ($i = 1; $i < 301; $i++) {
            $jobs->put($i, [
                'id' => $i,
                'title' => 'React Developer',
                'views' => 100,
            ]);
        }

        $api = Mockery::mock(ApiClient::class)
            ->shouldReceive('patch')
            ->times(6)
            ->withArgs([
                '/jobs/collection',
                Mockery::on(function ($args) {
                    return $args['jobs']->count() === 50;
                }),
            ])
            ->andReturn(new Collection([]))
            ->getMock();

        $repository = new ApiRepository($api, 'jobs');

        $repository->updateCollection($jobs);
    }

    /**
     * @test
     * @group Integration
     */
    public function it_can_accept_arrays_when_updating()
    {
        $jobs = [];

        for ($i = 0; $i < 30; $i++) {
            $jobs[$i] = [
                'id' => $i,
                'title' => 'React Developer',
                'views' => 100,
            ];
        }

        $api = Mockery::mock(ApiClient::class)
            ->shouldReceive('patch')
            ->once()
            ->withArgs([
                '/jobs/collection',
                Mockery::on(function ($args) {
                    return $args['jobs']->count() === 30;
                }),
            ])
            ->andReturn(new Collection([]))
            ->getMock();

        $repository = new ApiRepository($api, 'jobs');

        $repository->updateCollection($jobs);
    }

    /**
     * @test
     * @group Integration
     */
    public function it_returns_all_updated_entities()
    {
        $jobs = new Collection;

        for ($i = 0; $i < 200; $i++) {
            $jobs->put($i, [
                'id' => $i,
                'title' => 'React Developer',
                'views' => 100,
            ]);
        }

        $api = Mockery::mock(ApiClient::class)
            ->shouldReceive('patch')
            ->times(4)
            ->withAnyArgs()
            ->andReturn(...$jobs->chunk(50))
            ->getMock();

        $repository = new ApiRepository($api, 'jobs');

        $updated = $repository->updateCollection($jobs);

        $this->assertEquals($jobs, $updated);
    }
}
