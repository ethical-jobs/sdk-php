<?php

namespace Tests\Integration\Testing;

use EthicalJobs\SDK\Collection;
use EthicalJobs\SDK\Testing\ResponseFactory;
use Tests\TestCase;

class ResponseFactoryTest extends TestCase
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
    public function it_has_jobs_response()
    {
        $response = ResponseFactory::jobs();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertTrue($response->isNotEmpty());
    }

    /**
     * @test
     * @group Unit
     */
    public function it_has_job_response()
    {
        $response = ResponseFactory::job();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertTrue($response->isNotEmpty());
    }

    /**
     * @test
     * @group Unit
     */
    public function it_has_user_response()
    {
        $response = ResponseFactory::user();

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
