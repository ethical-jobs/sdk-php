<?php

namespace Tests\Integration\Repositories\Database;

use Tests\Fixtures\ModelMock;
use Tests\Fixtures\Models;
use Tests\Fixtures\Repositories\PersonDatabaseRepository;
use Tests\TestCase;

class WhereTest extends TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_has_fluent_interface()
    {
        $repository = new PersonDatabaseRepository;

        $isFluent = $repository
            ->where('first_name', '!=', 'Andrew');

        $this->assertInstanceOf(PersonDatabaseRepository::class, $isFluent);
    }

    /**
     * @test
     * @group Unit
     */
    public function it_can_add_a_where_query()
    {
        (new ModelMock(Models\Person::class))->create(['age' => 21]);
        (new ModelMock(Models\Person::class))->create(['age' => 22]);
        (new ModelMock(Models\Person::class))->create(['age' => 23]);

        $repository = new PersonDatabaseRepository;

        $result = $repository
            ->where('age', '!=', 22)
            ->find();

        $selectedPeople = $result->pluck('age')->toArray();

        $this->assertEquals($selectedPeople, [
            '21',
            '23',
        ]);
    }
}
