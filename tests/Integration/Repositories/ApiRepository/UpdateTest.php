<?php

namespace Tests\Integration\Repositories\ApiRepository;

use Mockery;
use EthicalJobs\SDK\ApiClient;
use EthicalJobs\SDK\Collection;
use EthicalJobs\SDK\Repositories\ApiRepository;

class UpdateTest extends \Tests\TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_can_update_an_entity_and_return_it()
    {
        $expected = new Collection(['entities' => 'invoices']);
        
        $api = Mockery::mock(ApiClient::class)
            ->shouldReceive('patch')
            ->once()
            ->with('/invoices/245', [
                'amount'    => 123.34,
                'payment'   => 'cc',
            ])
            ->andReturn($expected)
            ->getMock();

        $repository = new ApiRepository($api, 'invoices');         

        $result = $repository->update(245, [
            'amount'    => 123.34,
            'payment'   => 'cc',
        ]);

        $this->assertEquals($expected, $result);
    }    
}
