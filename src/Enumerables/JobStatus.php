<?php

namespace EthicalJobs\SDK\Enumerables;

/**
 * Job status
 */
class JobStatus extends Enum
{
    /**
     * The Enum base class has a __callStatic method defined which returns the const variable name if invoked.
     * So renaming the variable to get consistent value when using constant directly
     *
     */
    const DRAFT = "DRAFT";

    const PENDING = "PENDING";

    const APPROVED = "APPROVED";
}
