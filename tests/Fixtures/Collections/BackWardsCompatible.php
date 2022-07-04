<?php

namespace Tests\Fixtures\Collections;

use EthicalJobs\SDK\Storage\LegacyCollection;
use Tests\Fixtures\Models;

class BackWardsCompatible extends LegacyCollection
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
