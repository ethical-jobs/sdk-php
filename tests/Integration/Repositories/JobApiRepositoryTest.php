<?php

namespace Tests\Integration\Repositories;

use EthicalJobs\SDK\ApiClient;
use EthicalJobs\SDK\Repositories\JobApiRepository;
use Mockery;
use Tests\TestCase;

class JobApiRepositoryTest extends TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_has_correct_base_resource()
    {
        $api = Mockery::mock(ApiClient::class);

        $repository = new JobApiRepository($api);

        $this->assertEquals('jobs', $repository->getResource());
    }
}
