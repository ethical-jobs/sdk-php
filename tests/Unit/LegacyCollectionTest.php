<?php

namespace Tests\Integration\Repositories\Database;

use Illuminate\Support\Collection;
use Tests\Fixtures\Collections;
use Tests\Fixtures\Models;
use Tests\TestCase;

class CollectionTest extends TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_can_create_an_instance_of_an_item()
    {
        $this->assertInstanceOf(
            Models\Person::class,
            Collections\ModelsCollection::instance('people')
        );

        $this->assertInstanceOf(
            Models\Family::class,
            Collections\ModelsCollection::instance('families')
        );

        $this->assertInstanceOf(
            Models\Vehicle::class,
            Collections\ModelsCollection::instance('vehicles')
        );
    }

    /**
     * @test
     * @group Unit
     */
    public function it_returns_null_if_instance_does_not_exist()
    {
        $this->assertEquals(
            null,
            Collections\ModelsCollection::instance('animals')
        );

        $this->assertEquals(
            null,
            Collections\ModelsCollection::instance('planets')
        );
    }

    /**
     * @test
     * @group Unit
     */
    public function it_can_return_a_collection_of_instances()
    {
        $instances = Collections\ModelsCollection::instances();

        $expected = new Collection([
            'families' => new Models\Family,
            'people' => new Models\Person,
            'vehicles' => new Models\Vehicle,
        ]);

        $this->assertEquals($expected, $instances);
    }

    /**
     * @test
     * @group Unit
     */
    public function it_is_arrayable()
    {
        $collection = new Collections\ModelsCollection;

        $this->assertEquals($collection->all(), [
            'families' => Models\Family::class,
            'people' => Models\Person::class,
            'vehicles' => Models\Vehicle::class,
        ]);
    }

    /**
     * @test
     * @group Unit
     */
    public function it_can_return_collection_keys()
    {
        $collection = new Collections\ModelsCollection;

        $this->assertEquals($collection->keys()->toArray(), [
            'families',
            'people',
            'vehicles',
        ]);
    }

    /**
     * @test
     * @group Unit
     */
    public function it_is_backwards_compatible_with_previous_instantiation()
    {
        $collection = new Collections\BackWardsCompatible;

        $this->assertEquals($collection->all(), [
            'families' => Models\Family::class,
            'people' => Models\Person::class,
            'vehicles' => Models\Vehicle::class,
        ]);
    }
}
