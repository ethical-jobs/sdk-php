<?php

namespace EthicalJobs\SDK\Repositories;

use EthicalJobs\SDK\ApiClient;
use EthicalJobs\SDK\Collection;
use EthicalJobs\Storage\Contracts\Repository;

/**
 * Api resource repository
 *
 * @author Andrew McLagan <andrew@ethicaljobs.com.au>
 */
class TaxonomyApiRepository extends ApiRepository
{
    /**
     * Taxonomies collection
     *
     * @var Collection
     */
    protected $taxonomies;

    /**
     * Object constructor
     *
     * @param ApiClient $api
     * @return void
     */
    public function __construct(ApiClient $api)
    {
        parent::__construct($api, '/');

        $this->fetchTaxonomies();
    }

    /**
     * Patch a collection of jobs
     *
     * @return void
     */
    protected function fetchTaxonomies()
    {
        $response = $this->api->appData();

        $taxonomies = array_get($response, 'data.taxonomies', []);

        $this->taxonomies = new Collection($taxonomies);
    }

    /**
     * {@inheritdoc}
     */
    public function findById($id)
    {
        return $this->taxonomies->get($id);
    }

    /**
     * {@inheritdoc}
     */
    public function findByField(string $field, $value)
    {
        return $this->taxonomies->where($field, $value)->first();
    }

    /**
     * {@inheritdoc}
     */
    public function where(string $field, $operator, $value = null): Repository
    {
        $this->taxonomies = $this->taxonomies->filter(function ($item) use ($field, $operator, $value) {
            switch ($operator) {
                case '>':
                    return $item[$field] > $value;
                case '<':
                    return $item[$field] < $value;
                case '>=':
                    return $item[$field] >= $value;
                case '<=':
                    return $item[$field] <= $value;
                case '!=':
                    return $item[$field] != $value;
                default:
                case '=':
                    return $item[$field] == $value;
            }
        });

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function whereIn(string $field, array $values): Repository
    {
        $this->taxonomies = $this->taxonomies->whereIn($field, $values);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function orderBy(string $field, string $direction): Repository
    {
        $this->taxonomies = strtolower($direction) === 'desc' ?
            $this->taxonomies->sortByDesc($field) :
            $this->taxonomies->sortBy($field);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function limit(int $limit): Repository
    {
        $this->taxonomies = $this->taxonomies->take($limit);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function find(): iterable
    {
        return $this->taxonomies;
    }

    /**
     * Set the working taxonomy
     *
     * @param string $taxonomy
     * @return $this
     */
    public function taxonomy(string $taxonomy): Repository
    {
        $taxonomyArr = $this->taxonomies->get($taxonomy);

        $this->taxonomies = new Collection($taxonomyArr);

        return $this;
    }
}