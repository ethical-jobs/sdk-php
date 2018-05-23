<?php

namespace Tests\Unit;

use EthicalJobs\SDK\ResponseSelector;
use EthicalJobs\SDK\Collection;

class ResultsTest extends \Tests\TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_can_select_response_result_for_single_result()
    {
        $response = new Collection([
            'data' => [
                'entities' => [
                    'jobs' => [
                        827 => ['id' => 827, 'title' => 'Developer'],
                        276 => ['id' => 276, 'title' => 'Engineer'],
                        98 => ['id' => 98, 'title' => 'Web Designer'],
                    ],
                    'users' => [
                        111 => ['id' => 111, 'name' => 'John'],
                        276 => ['id' => 276, 'name' => 'Andrew'],
                        182 => ['id' => 182, 'name' => 'Jan'],
                    ],
                ],
                'result' => 276,
            ],
        ]);

        $this->assertEquals(ResponseSelector::select($response)->result(), 276);
    }

    /**
     * @test
     * @group Unit
     */
    public function it_can_select_response_result_for_collection_result()
    {
        $response = new Collection([
            'data' => [
                'entities' => [
                    'jobs' => [
                        827 => ['id' => 827, 'title' => 'Developer'],
                        276 => ['id' => 276, 'title' => 'Engineer'],
                        98 => ['id' => 98, 'title' => 'Web Designer'],
                    ],
                    'users' => [
                        111 => ['id' => 111, 'name' => 'John'],
                        276 => ['id' => 276, 'name' => 'Andrew'],
                        182 => ['id' => 182, 'name' => 'Jan'],
                    ],
                ],
                'result' => [
                    2726,
                    2746,
                    9982,
                    98932,
                    1,
                ],
            ],
        ]);

        $this->assertEquals(ResponseSelector::select($response)->result(), [
            2726,
            2746,
            9982,
            98932,
            1,
        ]);
    }    

    /**
     * @test
     * @group Unit
     */
    public function it_returns_empty_array_when_params_are_invalid()
    {
        $response = new Collection([
            'data' => [],
        ]);

        $this->assertEquals(ResponseSelector::select($response)->result(), []);
    }
}
