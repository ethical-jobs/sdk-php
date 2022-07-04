<?php

namespace Tests\Integration\Storage\DatabaseRepository;

use Tests\Fixtures\ModelMock;
use Tests\Fixtures\Models;
use Tests\Fixtures\Repositories\PersonDatabaseRepository;
use Tests\StorageTestCase;

class FindByFieldTest extends StorageTestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_can_find_by_a_field()
    {
        $person = (new ModelMock(Models\Person::class))->create();

        $repository = new PersonDatabaseRepository;

        $found = $repository
            ->findByField('first_name', $person->first_name);

        $this->assertEquals($person->first_name, $found->first_name);
    }

    /**
     * @test
     * @group Unit
     */
    public function it_returns_null_when_no_model_found()
    {
        $repository = new PersonDatabaseRepository;

        $this->assertEquals(
            $repository->findByField('first_name', 'Jesus'),
            null
        );
    }
}
