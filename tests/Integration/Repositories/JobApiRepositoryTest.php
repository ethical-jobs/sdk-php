<?php

namespace Tests\Integration\Repositories;

use Mockery;
use EthicalJobs\SDK\ApiClient;
use EthicalJobs\SDK\Repositories\JobApiRepository;

class JobApiRepositoryTest extends \Tests\TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_has_correct_base_resource()
    {
    	$api = Mockery::mock(ApiClient::class);

        $repository = new JobApiRepository($api);

        $this->assertEquals('/jobs', $repository->getResource());
    }      
}
