<?php

namespace Tests\Integration\Storage\DatabaseRepository;

use Tests\Fixtures\ModelMock;
use Tests\Fixtures\Models;
use Tests\Fixtures\Repositories\PersonDatabaseRepository;
use Tests\StorageTestCase;

class LimitTest extends StorageTestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_has_fluent_interface()
    {
        $repository = new PersonDatabaseRepository;

        $isFluent = $repository->limit(5);

        $this->assertInstanceOf(PersonDatabaseRepository::class, $isFluent);
    }

    /**
     * @test
     * @group Unit
     */
    public function it_can_add_a_where_query()
    {
        $firstCount = 1;
        while($firstCount <= 20) {
            (new ModelMock(Models\Person::class))->create();
            $firstCount++;
        }

        $repository = new PersonDatabaseRepository;

        $result = $repository
            ->limit(15)
            ->find();

        $this->assertEquals(15, $result->count());
    }
}
