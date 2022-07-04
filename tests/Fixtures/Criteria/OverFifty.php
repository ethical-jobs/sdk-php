<?php

namespace Tests\Fixtures\Criteria;

use EthicalJobs\SDK\Storage\Contracts\Criteria;
use EthicalJobs\SDK\Storage\Contracts\Repository;

class OverFifty implements Criteria
{
    public function apply(Repository $repository)
    {
        $repository
            ->where('age', '>', 50);

        return $this;
    }
}
