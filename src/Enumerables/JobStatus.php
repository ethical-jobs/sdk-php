<?php

namespace EthicalJobs\SDK\Enumerables;

/**
 * Job status
 *
 * @author Andrew McLagan <andrew@ethicaljobs.com.au>
 */
class JobStatus extends Enum
{
    const DRAFT = "Draft";

    const PENDING = "Pending approval";

    const APPROVED = "Approved";
}
