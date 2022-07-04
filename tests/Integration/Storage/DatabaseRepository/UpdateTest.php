<?php

namespace Tests\Integration\Storage\DatabaseRepository;

use Tests\Fixtures\ModelMock;
use Tests\Fixtures\Models;
use Tests\Fixtures\Repositories\PersonDatabaseRepository;
use Tests\StorageTestCase;

class UpdateTest extends StorageTestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_can_update_an_entity_and_return_it()
    {
        $person = (new ModelMock(Models\Person::class))->create();

        $repository = new PersonDatabaseRepository;

        $updated = $repository->update($person, [
            'first_name' => 'Andrew',
            'last_name' => 'McLagan',
        ]);

        $this->assertTrue($updated->first_name === 'Andrew');
        $this->assertTrue($updated->last_name === 'McLagan');
    }
}
