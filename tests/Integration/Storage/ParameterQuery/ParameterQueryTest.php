<?php

namespace Tests\Integration\Storage\ParameterQuery;

use Tests\Fixtures\ModelMock;
use Tests\Fixtures\Models;
use Tests\Fixtures\ParameterQueries\PersonParameterQuery;
use Tests\Fixtures\Repositories\PersonDatabaseRepository;
use Tests\StorageTestCase;

class ParameterQueryTest extends StorageTestCase
{
    /**
     * @test
     * @group Integration
     */
    public function it_can_set_and_get_its_repository()
    {
        $personRepository = new PersonDatabaseRepository;

        $paramQuery = new PersonParameterQuery($personRepository);

        $this->assertEquals($personRepository, $paramQuery->getRepository());
    }

    /**
     * @test
     * @group Integration
     */
    public function it_queries_by_parameters()
    {
        $expectedPerson = (new ModelMock(Models\Person::class))->create([
            'age' => 65,
            'email' => 'andrew@ethicaljobs.com.au',
        ]);

        (new ModelMock(Models\Person::class))->create([
            'age' => 45,
            'email' => 'andrew@ethicaljobs.com.au',
        ]);

        $paramQuery = new PersonParameterQuery(new PersonDatabaseRepository);

        $people = $paramQuery->find([
            'ages' => [23, 65, 55, 18],
            'email' => 'andrew@ethicaljobs.com.au',
        ]);

        $person = $people->first();

        $this->assertEquals($expectedPerson->id, $person->id);
        $this->assertEquals($expectedPerson->first_name, $person->first_name);
    }

    /**
     * @test
     * @group Integration
     */
    public function it_can_call_snake_or_camel_case_param_funcs()
    {
        (new ModelMock(Models\Person::class))->create([
            'last_name' => 'mclagan',
        ]);

        (new ModelMock(Models\Person::class))->create([
            'last_name' => 'kisilevsky',
        ]);

        $paramQuery = new PersonParameterQuery(new PersonDatabaseRepository);

        $people = $paramQuery->find([
            'last_name' => 'mclagan',
        ]);

        foreach ($people as $person) {
            $this->assertEquals($person->last_name, 'mclagan');
        }

        $paramQuery = new PersonParameterQuery(new PersonDatabaseRepository);

        $people = $paramQuery->find([
            'lastName' => 'mclagan',
        ]);

        foreach ($people as $person) {
            $this->assertEquals($person->last_name, 'mclagan');
        }
    }
}
