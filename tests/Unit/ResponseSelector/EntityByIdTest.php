<?php

declare(strict_types=1);

namespace Tests\Unit;

use EthicalJobs\SDK\Collection;
use EthicalJobs\SDK\ResponseSelector;
use Tests\TestCase;

class EntityByIdTest extends TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_can_select_an_entity_by_Id()
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

        $this->assertEquals(ResponseSelector::select($response)->entityById('jobs', 827),
            ['id' => 827, 'title' => 'Developer']);
    }

    /**
     * @test
     * @group Unit
     */
    public function it_returns_empty_array_when_params_are_invalid()
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
                'result' => 7363,
            ],
        ]);

        $this->assertEquals(ResponseSelector::select($response)->entityById('foobar', 292992929), []);

        $this->assertEquals(ResponseSelector::select($response)->entityById('users', 298298), []);
    }
}
