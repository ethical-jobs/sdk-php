<?php

namespace EthicalJobs\SDK\Storage\Contracts;

interface Hydrator
{
    /**
     * Hydrates collection of entities
     *
     * @param iterable $collection
     * @return iterable
     */
    public function hydrateCollection(iterable $collection): iterable;

    /**
     * Hydrates single entity
     *
     * @param mixed $entity
     * @return mixed
     */
    public function hydrateEntity($entity);
}
