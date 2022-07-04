<?php

namespace Tests\Integration\Repositories\Database;

use Tests\Fixtures\ModelMock;
use Tests\Fixtures\Models;
use Tests\Fixtures\Repositories\PersonDatabaseRepository;
use Tests\TestCase;

class FindByIdTest extends TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_returns_a_model_if_one_is_passed_in()
    {
        $person = (new ModelMock(Models\Person::class))->create();

        $repository = new PersonDatabaseRepository;

        $result = $repository->findById($person);

        $this->assertEquals($person->id, $result->id);
        $this->assertEquals($person->first_name, $result->first_name);
    }

    /**
     * @test
     * @group Unit
     */
    public function it_can_find_by_id()
    {
        $person = (new ModelMock(Models\Person::class))->create();

        $repository = new PersonDatabaseRepository;

        $result = $repository->findById($person->id);

        $this->assertEquals($person->id, $result->id);
        $this->assertEquals($person->first_name, $result->first_name);
    }

    /**
     * @test
     * @group Unit
     */
    public function it_returns_null_when_no_model_found()
    {
        $repository = new PersonDatabaseRepository;

        $this->assertEquals(
            $repository->findById(1337),
            null
        );
    }
}
