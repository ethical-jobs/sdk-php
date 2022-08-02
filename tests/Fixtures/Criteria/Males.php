<?php

namespace Tests\Fixtures\Criteria;

use EthicalJobs\SDK\Storage\Contracts\Criteria;
use EthicalJobs\SDK\Storage\Contracts\Repository;

class Males implements Criteria
{
    public function apply(Repository $repository)
    {
        $repository
            ->where('sex', '=', 'male');

        return $this;
    }
}
