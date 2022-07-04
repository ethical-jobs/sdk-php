<?php

namespace Tests\Integration\Storage\DatabaseRepository;

use Illuminate\Support\Collection;
use Tests\Fixtures\ModelMock;
use Tests\Fixtures\Models;
use Tests\Fixtures\Repositories\PersonDatabaseRepository;
use Tests\StorageTestCase;

class UpdateCollectionTest extends StorageTestCase
{
    /**
     * @test
     * @group Integration
     */
    public function it_updates_a_collection_of_entities()
    {
        $firstCount = 1;
        $peopleToUpdate = new Collection();
        while($firstCount <= 6) {
            $peopleToUpdate->push((new ModelMock(Models\Person::class))->create());
            $firstCount++;
        }
        $peopleToUpdate = $peopleToUpdate->map(function ($person) {
            return [
                'id' => $person->id,
                'first_name' => 'Andrew',
                'last_name' => 'McLagan',
            ];
        })->keyBy('id');

        $repository = new PersonDatabaseRepository;

        $updatedPeople = $repository->updateCollection($peopleToUpdate);

        $updatedPeople->each(function ($person) {
            $this->assertEquals($person->first_name, 'Andrew');
            $this->assertEquals($person->last_name, 'McLagan');
        });
    }

    /**
     * @test
     * @group Integration
     */
    public function it_can_accept_arrays_when_updating()
    {
        $firstCount = 1;
        $peopleToUpdate = new Collection();
        while($firstCount <= 6) {
            $peopleToUpdate->push((new ModelMock(Models\Person::class))->create());
            $firstCount++;
        }
        $peopleToUpdate = $peopleToUpdate->map(function ($person) {
            return [
                'id' => $person->id,
                'first_name' => 'Andrew',
                'last_name' => 'McLagan',
            ];
        })
        ->keyBy('id')
        ->toArray();

        $repository = new PersonDatabaseRepository;

        $updatedPeople = $repository->updateCollection($peopleToUpdate);

        $updatedPeople->each(function ($person) {
            $this->assertEquals($person->first_name, 'Andrew');
            $this->assertEquals($person->last_name, 'McLagan');
        });
    }

    /**
     * @test
     * @group Integration
     */
    public function it_returns_all_updated_entities()
    {
        $firstCount = 1;
        $peopleToUpdate = new Collection();
        while($firstCount <= 6) {
            $peopleToUpdate->push((new ModelMock(Models\Person::class))->create());
            $firstCount++;
        }
        $peopleToUpdate = $peopleToUpdate->map(function ($person) {
            return [
                'id' => $person->id,
                'first_name' => 'Andrew',
                'last_name' => 'McLagan',
            ];
        })
        ->keyBy('id');

        $repository = new PersonDatabaseRepository;

        $updatedPeople = $repository->updateCollection($peopleToUpdate);

        $updatedPeople->each(function ($person) use ($peopleToUpdate) {
            $this->assertTrue($peopleToUpdate->has($person->id));
        });
    }
}
