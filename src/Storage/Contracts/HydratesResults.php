<?php

namespace EthicalJobs\SDK\Storage\Contracts;

interface HydratesResults
{
    /**
     * Sets the current hydrator instance
     *
     * @param Hydrator $hydrator
     * @return $this
     */
    public function setHydrator(Hydrator $hydrator);

    /**
     * Returns the current hydrator instance
     *
     * @return Hydrator
     */
    public function getHydrator(): Hydrator;
}
