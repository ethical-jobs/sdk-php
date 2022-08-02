<?php

namespace Tests\Fixtures\Repositories;

use EthicalJobs\SDK\Storage\Contracts\Repository;
use EthicalJobs\SDK\Storage\CriteriaCollection;
use EthicalJobs\SDK\Storage\DatabaseRepository;
use Tests\Fixtures\Models;

class PersonDatabaseRepository extends DatabaseRepository
{
    protected $criteria;

    /**
     * Object constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct(new Models\Person);
    }

    /**
     * {@inheritdoc}
     */
    public function search(string $term = ''): Repository
    {
        if (strlen($term) > 0) {
            $this->query->where('first_name', 'like', "%{$term}%")
                ->orWhere('last_name', 'like', "%{$term}%")
                ->orWhere('age', 'like', "%{$term}%");
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setCriteriaCollection(CriteriaCollection $collection)
    {
        $this->criteria = $collection;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCriteriaCollection(): CriteriaCollection
    {
        return $this->criteria;
    }

    /**
     * {@inheritdoc}
     */
    public function addCriteria(string $criteria)
    {
        $this->criteria->push($criteria);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function applyCriteria()
    {
        foreach ($this->criteria as $criteria) {
            $criteria->apply($this);
        }

        return $this;
    }
}
