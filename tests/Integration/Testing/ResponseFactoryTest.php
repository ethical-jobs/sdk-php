<?php

namespace Tests\Integration\Repositories\ApiRepository;

use EthicalJobs\SDK\Testing\ResponseFactory;
use EthicalJobs\SDK\Collection;

class ResponseFactoryTest extends \Tests\TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_has_jobsSearch_response()
    {
        $response = ResponseFactory::jobsSearch();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertTrue($response->isNotEmpty());
    }

    /**
     * @test
     * @group Unit
     */
    public function it_has_taxonomies_response()
    {
        $response = ResponseFactory::taxonomies();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertTrue($response->isNotEmpty());
    }    
}
