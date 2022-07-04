<?php

namespace Tests\Integration\Repositories\Database;

use Tests\Fixtures\ModelMock;
use Tests\Fixtures\Models;
use Tests\Fixtures\Repositories\PersonDatabaseRepository;
use Tests\TestCase;

class WhereInTest extends TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_has_fluent_interface()
    {
        $repository = new PersonDatabaseRepository;

        $isFluent = $repository
            ->whereIn('status', ['APPROVED', 'DRAFT']);

        $this->assertInstanceOf(PersonDatabaseRepository::class, $isFluent);
    }

    /**
     * @test
     * @group Unit
     */
    public function it_can_add_a_where_query()
    {
        (new ModelMock(Models\Person::class))->create(['age' => 21]);
        (new ModelMock(Models\Person::class))->create(['age' => 34]);
        (new ModelMock(Models\Person::class))->create(['age' => 16]);
        (new ModelMock(Models\Person::class))->create(['age' => 34]);

        $repository = new PersonDatabaseRepository;

        $result = $repository
            ->whereIn('age', [21, 34])
            ->find();

        $agesSelected = $result->pluck('age')->toArray();

        $this->assertEquals($agesSelected, [
            '21',
            '34',
            '34',
        ]);
    }
}
