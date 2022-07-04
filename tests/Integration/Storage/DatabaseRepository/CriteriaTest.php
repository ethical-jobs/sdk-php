<?php

namespace Tests\Integration\Repositories\Database;

use EthicalJobs\Storage\CriteriaCollection;
use Tests\Fixtures\Criteria;
use Tests\Fixtures\ModelMock;
use Tests\Fixtures\Models;
use Tests\Fixtures\Repositories\PersonDatabaseRepository;
use Tests\TestCase;

class CriteriaTest extends TestCase
{
    /**
     * @test
     * @group Integration
     */
    public function its_criteria_are_an_empty_collection_by_default()
    {
        $repository = new PersonDatabaseRepository;

        $criteria = $repository->getCriteriaCollection();

        $this->assertInstanceOf(CriteriaCollection::class, $criteria);

        $this->assertTrue($criteria->isEmpty());
    }

    /**
     * @test
     * @group Integration
     */
    public function it_can_set_and_get_it_criteria_collection()
    {
        $repository = new PersonDatabaseRepository;

        $collection = new CriteriaCollection([
            Criteria\Males::class,
            Criteria\OverFifty::class,
        ]);

        $repository->setCriteriaCollection($collection);

        $this->assertEquals($repository->getCriteriaCollection(), $collection);
    }

    /**
     * @test
     * @group Integration
     */
    public function it_can_add_criteria_items()
    {
        $repository = new PersonDatabaseRepository;

        $expected = $repository->addCriteria(Criteria\OverFifty::class)
            ->getCriteriaCollection()
            ->get(Criteria\OverFifty::class);

        $this->assertEquals(new Criteria\OverFifty, $expected);
    }

    /**
     * @test
     * @group Integration
     */
    public function it_can_apply_criteria()
    {
        $firstCount = 1;
        while($firstCount <= 5) {
            (new ModelMock(Models\Person::class))->create(['age' => 29]);
            (new ModelMock(Models\Person::class))->create(['age' => 55]);
            $firstCount++;
        }

        $repository = new PersonDatabaseRepository;

        $people = $repository
            ->addCriteria(Criteria\OverFifty::class)
            ->find();

        $people->each(function ($person) {
            $this->assertTrue($person->age > 50);
        });
    }
}
