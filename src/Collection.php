<?php

declare(strict_types=1);

namespace EthicalJobs\SDK;

/**
 * Response selector
 *
 * @author Andrew McLagan <andrew@ethicaljobs.com.au>
 */
class Collection extends \Illuminate\Support\Collection
{
    /**
     * Api response selector
     *
     * @return ResponseSelector
     */
    public function select(): ResponseSelector
    {
        return new ResponseSelector($this);
    }
}
