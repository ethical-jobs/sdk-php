<?php

declare(strict_types=1);

namespace EthicalJobs\SDK\Enumerables;

/**
 * Job status
 *
 * @method static string DRAFT()
 * @phpstan-method static "DRAFT" DRAFT()
 * @method static string PENDING()
 * @phpstan-method static "PENDING" PENDING()
 * @method static string APPROVED()
 * @phpstan-method static "APPROVED" APPROVED()
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
