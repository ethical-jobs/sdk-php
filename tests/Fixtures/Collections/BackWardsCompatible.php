<?php

namespace Tests\Fixtures\Collections;

use EthicalJobs\Storage\Collection;
use Tests\Fixtures\Models;

class BackWardsCompatible extends Collection
{
    /**
     * Create a new collection.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct([
            'families' => Models\Family::class,
            'people' => Models\Person::class,
            'vehicles' => Models\Vehicle::class,
        ]);
    }
}
