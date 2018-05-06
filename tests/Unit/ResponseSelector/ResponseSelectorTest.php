<?php

namespace Tests\Unit;

use EthicalJobs\SDK\ResponseSelector;
use EthicalJobs\SDK\Collection;

class ResponseSelectorTest extends \Tests\TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_can_set_and_get_ites_response()
    {
        $responseOne = new Collection([ 'data' => [ 'foo' => 'bar'] ]);

        $responseTwo = new Collection([ 'datum' => [ 'foo' => 'bar-bar-bar'] ]);

        $selector = ResponseSelector::select($responseOne);

        $this->assertEquals($selector->getResponse(), $responseOne);

        $this->assertInstanceOf(ResponseSelector::class, $selector->setResponse($responseTwo));

        $this->assertEquals($selector->getResponse(), $responseTwo);
    }    

    /**
     * @test
     * @group Unit
     */
    public function it_can_set_arrays_as_a_response()
    {
        $response = [ 'data' => [ 'foo' => 'bar'] ];

        $selector = ResponseSelector::select($response);

        $this->assertTrue(is_iterable($selector->getResponse()));

        $this->assertEquals($selector->getResponse(), new Collection($response));
    }        
}
