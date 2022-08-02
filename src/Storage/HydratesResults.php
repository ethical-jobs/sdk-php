<?php

namespace EthicalJobs\SDK\Storage;

use EthicalJobs\SDK\Storage\Contracts\Hydrator;

trait HydratesResults
{
    protected Hydrator $hydrator;

    public function getHydrator(): Hydrator
    {
        return $this->hydrator;
    }

    public function setHydrator(Hydrator $hydrator)
    {
        $this->hydrator = $hydrator;

        return $this;
    }
}
