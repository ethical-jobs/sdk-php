<?php

namespace Tests\Integration\Storage;

use EthicalJobs\SDK\Storage\CriteriaCollection;
use Tests\Fixtures\Criteria;
use Tests\StorageTestCase;

class CriteriaCollectionTest extends StorageTestCase
{
    /**
     * @test
     * @group Integration
     */
    public function it_creates_keyed_instances_when_pushing_new_criteria()
    {
        $collection = new CriteriaCollection;

        $collection
            ->push(Criteria\OverFifty::class)
            ->push(Criteria\Males::class);

        $this->assertEquals($collection->toArray(), [
            Criteria\OverFifty::class => $collection->first(),
            Criteria\Males::class => $collection->last(),
        ]);
    }
}
