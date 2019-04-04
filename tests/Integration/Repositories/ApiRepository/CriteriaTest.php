<?php

namespace Tests\Integration\Repositories\ApiRepository;

use EthicalJobs\SDK\ApiClient;
use EthicalJobs\SDK\Repositories\ApiRepository;
use EthicalJobs\Storage\CriteriaCollection;
use Mockery;
use Tests\TestCase;

class CriteriaTest extends TestCase
{
    /**
     * @test
     * @group Integration
     */
    public function its_criteria_are_an_empty_collection_by_default()
    {
        $api = Mockery::mock(ApiClient::class);

        $repository = new ApiRepository($api);

        $criteria = $repository->getCriteriaCollection();

        $this->assertInstanceOf(CriteriaCollection::class, $criteria);

        $this->assertTrue($criteria->isEmpty());
    }

    /**
     * @test
     * @group Integration
     */
    public function it_can_set_and_get_it_criteria_collection()
    {
        $api = Mockery::mock(ApiClient::class);

        $repository = new ApiRepository($api);

        $collection = new CriteriaCollection(['foo' => 'bar']);

        $repository->setCriteriaCollection($collection);

        $this->assertEquals($repository->getCriteriaCollection(), $collection);
    }
}
