<?php

namespace Tests\Integration\Repositories\ApiRepository;

use Mockery;
use EthicalJobs\SDK\ApiClient;
use EthicalJobs\SDK\Collection;
use EthicalJobs\SDK\Repositories\ApiRepository;

class OrderByTest extends \Tests\TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_has_fluent_interface()
    {
        $api = Mockery::mock(ApiClient::class);

        $repository = new ApiRepository($api, 'search/jobs');

        $isFluent = $repository
            ->orderBy('approved_at', 'DESC');

        $this->assertInstanceOf(ApiRepository::class, $isFluent);
    }   

    /**
     * @test
     * @group Unit
     */
    public function it_can_add_a_orderBy_query()
    {
        $expected = new Collection(['entities' => 'jobs']);
        
        $api = Mockery::mock(ApiClient::class)
            ->shouldReceive('get')
            ->once()
            ->with('/search/jobs', [
                'orderBy'   => 'approved_at',
                'order'     => 'DESC',
            ])
            ->andReturn($expected)
            ->getMock();

        $repository = new ApiRepository($api, 'search/jobs');

        $repository
            ->orderBy('approved_at', 'DESC')
            ->find();
    }    
}
