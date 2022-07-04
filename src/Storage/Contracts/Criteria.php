<?php

namespace EthicalJobs\SDK\Storage\Contracts;

interface Criteria
{
    /**
     * Apply criteria to repository query
     *
     * @param Repository $repository
     * @return mixed
     */
    public function apply(Repository $repository);
}
