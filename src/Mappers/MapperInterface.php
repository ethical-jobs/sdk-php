<?php

declare(strict_types=1);

namespace EthicalJobs\SDK\Mappers;

/**
 * Mapper interface
 * \
 * @author Sebastian Sibelle <sebastian@ethicaljobs.com.au>
 */
interface MapperInterface
{
    /**
     * Maps the data
     *
     * @param int $taxonomyId
     * @param string $type
     * @return string
     */
    public function map(int $taxonomyId, string $type): string;
}
