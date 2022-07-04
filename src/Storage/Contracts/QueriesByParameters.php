<?php

namespace EthicalJobs\Storage\Contracts;

interface QueriesByParameters
{
    /**
     * Sets the repository
     *
     * @param Repository $repository
     * @return QueriesByParameters
     */
    public function setRepository(Repository $repository): QueriesByParameters;

    /**
     * Returns the repository
     *
     * @return Repository
     */
    public function getRepository(): Repository;

    /**
     * Returns results from the parameter query
     *
     * @param array $parameters
     * @return iterable
     */
    public function find(array $parameters): iterable;
}
