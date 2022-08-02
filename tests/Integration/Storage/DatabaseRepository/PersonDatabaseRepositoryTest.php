<?php

namespace Tests\Integration\Storage\DatabaseRepository;

use Tests\Fixtures\Models;
use Tests\Fixtures\Repositories\PersonDatabaseRepository;
use Tests\StorageTestCase;

class PersonDatabaseRepositoryTest extends StorageTestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_can_set_and_get_its_storage_engine()
    {
        // Via constructor
        $repository = new PersonDatabaseRepository;
        $this->assertEquals($repository->getStorageEngine(), (new Models\Person)->query());

        // Via method
        $repository = new PersonDatabaseRepository;
        $repository->setStorageEngine((new Models\Family)->query());
        $this->assertEquals($repository->getStorageEngine(), (new Models\Family)->query());
    }
}
