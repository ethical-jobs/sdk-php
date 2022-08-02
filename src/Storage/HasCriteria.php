<?php

declare(strict_types=1);

namespace EthicalJobs\SDK\Storage;

trait HasCriteria
{
    protected $criteria;

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
