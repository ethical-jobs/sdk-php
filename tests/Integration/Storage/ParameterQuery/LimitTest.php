<?php

namespace Tests\Integration\Storage\ParameterQuery;

use Tests\Fixtures\ModelMock;
use Tests\Fixtures\Models;
use Tests\Fixtures\ParameterQueries\PersonParameterQuery;
use Tests\Fixtures\Repositories\PersonDatabaseRepository;
use Tests\StorageTestCase;

class LimitTest extends StorageTestCase
{
    /**
     * @test
     * @group Integration
     */
    public function it_maps_a_limit_parameter()
    {
        (new ModelMock(Models\Person::class))->create([
            'first_name' => 'iraS',
            'age' => 44,
        ]);

        (new ModelMock(Models\Person::class))->create([
            'first_name' => 'Werdna',
            'age' => 34,
        ]);

        (new ModelMock(Models\Person::class))->create([
            'first_name' => 'Divad',
            'age' => 36,
        ]);

        (new ModelMock(Models\Person::class))->create([
            'first_name' => 'ydnas',
            'age' => 38,
        ]);

        $paramQuery = new PersonParameterQuery(new PersonDatabaseRepository);

        $people = $paramQuery->find([
            'limit' => 2,
        ]);

        $this->assertEquals(2, $people->count());
    }
}
