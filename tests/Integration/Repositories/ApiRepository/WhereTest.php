<?php

namespace Tests\Integration\Repositories\ApiRepository;

use Mockery;
use EthicalJobs\SDK\ApiClient;
use EthicalJobs\SDK\Collection;
use EthicalJobs\SDK\Repositories\ApiRepository;

class WhereTest extends \Tests\TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_has_fluent_interface()
    {
        $api = Mockery::mock(ApiClient::class);

        $repository = new ApiRepository($api);

        $isFluent = $repository
            ->where('status', '=', 'APPROVED');

        $this->assertInstanceOf(ApiRepository::class, $isFluent);
    }   

    /**
     * @test
     * @group Unit
     */
    public function it_can_add_a_where_query()
    {
        $expected = new Collection(['entities' => 'jobs']);

        $api = Mockery::mock(ApiClient::class)
            ->shouldReceive('get')
            ->once()
            ->with('/invoices', [
                'status' => 'APPROVED',
            ])
            ->andReturn($expected)
            ->getMock();

        $repository = new ApiRepository($api, 'invoices');

        $repository
            ->where('status', '=', 'APPROVED')
            ->find();
    } 

    /**
     * @test
     * @group Unit
     */
    public function its_where_clause_always_uses_the_equals_operator()
    {
        $expected = new Collection(['entities' => 'jobs']);
        
        $api = Mockery::mock(ApiClient::class)
            ->shouldReceive('get')
            ->once()
            ->with('/invoices', [
                'status' => 'APPROVED',
            ])
            ->andReturn($expected)
            ->getMock();

        $repository = new ApiRepository($api, 'invoices');

        $repository
            ->where('status', '>=', 'APPROVED')
            ->find();
    }         
}
