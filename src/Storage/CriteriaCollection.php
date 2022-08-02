<?php

declare(strict_types=1);

namespace EthicalJobs\SDK\Storage;

class CriteriaCollection extends LegacyCollection
{
    /**
     * Push a criteria class
     *
     * Unclear what the purpose of this is, why it doesn't push but instead puts or why it was made a dependency.
     *
     * @TODO Remove dependency on this and potentially entire package
     *
     * @param  mixed  $values [optional]
     * @return $this
     */
    public function push(...$values)
    {
        foreach ($values as $value) {
            $instance = new $value;

            $this->put($value, $instance);
        }

        return $this;
    }
}
