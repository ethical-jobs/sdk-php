<?php

namespace Tests\Integration\Testing;

use EthicalJobs\SDK\ApiClient;
use EthicalJobs\SDK\Testing\ResponseFactory;
use OutOfBoundsException;
use Tests\TestCase;

class MockingTest extends TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_can_mock_a_stack_of_responses()
    {
        $api = ApiClient::mock([
            ResponseFactory::response(204, ResponseFactory::jobs()),
            ResponseFactory::response(201, ResponseFactory::job()),
            ResponseFactory::response(200, ResponseFactory::user()),
        ]);

        $response = $api->get('/jobs');
        $this->assertEquals(ResponseFactory::jobs(), $response);

        $response = $api->get('/job/1234');
        $this->assertEquals(ResponseFactory::job(), $response);

        $response = $api->get('/user/1234');
        $this->assertEquals(ResponseFactory::user(), $response);

        try {
            $response = $api->get('/user/1234');
        } catch (OutOfBoundsException $exception) {
            $this->assertEquals('Mock queue is empty', $exception->getMessage());
        }
    }
}
