<?php

namespace Tests\Integration\Repositories\ApiRepository;

use EthicalJobs\SDK\ApiClient;
use EthicalJobs\SDK\Repositories\ApiRepository;
use Mockery;
use Tests\TestCase;

class ApiRepositoryTest extends TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_can_set_and_get_its_storage_engine_via_constructor()
    {
        $api = Mockery::mock(ApiClient::class);

        $repository = new ApiRepository($api);

        $this->assertEquals($repository->getStorageEngine(), $api);
    }

    /**
     * @test
     * @group Unit
     */
    public function it_can_set_and_get_its_storage_engine_via_methods()
    {
        $api = Mockery::mock(ApiClient::class);

        $repository = new ApiRepository($api);

        $apiTwo = Mockery::mock(ApiClient::class);

        $repository->setStorageEngine($apiTwo);

        $this->assertEquals($repository->getStorageEngine(), $apiTwo);
    }

    /**
     * @test
     * @group Unit
     */
    public function it_can_get_and_set_its_resource()
    {
        $api = Mockery::mock(ApiClient::class);

        $repository = new ApiRepository($api, 'people');

        $this->assertEquals($repository->getResource(), 'people');

        $repository = new ApiRepository($api, 'people');

        $repository->setResource('vehicles');

        $this->assertEquals($repository->getResource(), 'vehicles');
    }
}
