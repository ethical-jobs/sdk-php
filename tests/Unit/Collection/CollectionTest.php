<?php

declare(strict_types=1);

namespace Tests\Unit\Collection;

use EthicalJobs\SDK\Collection;
use EthicalJobs\SDK\ResponseSelector;
use Tests\TestCase;

class CollectionTest extends TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function its_select_function_returns_a_response_selector()
    {
        $collection = new Collection(['data' => ['foo' => 'bar']]);

        $this->assertInstanceOf(ResponseSelector::class, $collection->select());
    }

    /**
     * @test
     * @group Unit
     */
    public function its_select_function_can_select_data()
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

        $user = $response->select()->entityById('users', 276);

        $this->assertEquals($user, ['id' => 276, 'name' => 'Andrew']);
    }
}
