<?php

namespace Tests\Integration\Storage\DatabaseRepository;

use Tests\Fixtures\ModelMock;
use Tests\Fixtures\Models;
use Tests\Fixtures\Repositories\PersonDatabaseRepository;
use Tests\StorageTestCase;

class DeleteTest extends StorageTestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_can_delete_an_entity_and_return_it()
    {
        $person = (new ModelMock(Models\Person::class))->create([]);

        $this->assertTrue($person->deleted_at === null);

        $repository = new PersonDatabaseRepository;

        $deleted = $repository->delete($person->id);

        $this->assertTrue($deleted->deleted_at !== null);
    }
}
