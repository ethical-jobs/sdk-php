<?php

namespace EthicalJobs\Storage;

use EthicalJobs\Storage\Contracts\Hydrator;

trait HydratesResults
{
    /**
     * Hydrator instance
     *
     * @var Hydrator
     */
    protected $hydrator;

    /**
     * {@inheritdoc}
     */
    public function getHydrator(): Hydrator
    {
        return $this->hydrator;
    }

    /**
     * {@inheritdoc}
     */
    public function setHydrator(Hydrator $hydrator)
    {
        $this->hydrator = $hydrator;

        return $this;
    }
}
