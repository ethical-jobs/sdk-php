<?php

namespace EthicalJobs\SDK\Repositories;

use EthicalJobs\Storage\Contracts;
use EthicalJobs\Storage\CriteriaCollection;
use EthicalJobs\Storage\HasCriteria;
use EthicalJobs\SDK\Collection;
use EthicalJobs\SDK\ApiClient;

/**
 * Api repository
 *
 * @author Andrew McLagan <andrew@ethicaljobs.com.au>
 */

class ApiRepository implements Contracts\Repository, Contracts\HasCriteria
{
    use HasCriteria;

    /**
     * Api client instance
     *
     * @var EthicalJobs\SDK\ApiClient
     */
    protected $api;   

    /**
     * Resource path
     *
     * @var string
     */
    protected $resource;       

    /**
     * Http query vars
     *
     * @var array
     */
    protected $query = [];     

    /**
     * Object constructor
     *
     * @param EthicalJobs\SDK\ApiClient $api
     * @param string $resource
     * @return void
     */
    public function __construct(ApiClient $api, string $resource = '/')
    {
        $this->criteria = new CriteriaCollection;

        $this->setResource($resource);

        $this->setStorageEngine($api); 
    }

    /**
     * Sets the resource path in the API request
     *
     * @param string $resource
     * @return $this
     */
    public function setResource(string $resource = '/') : Contracts\Repository
    {
        $this->resource = $resource;

        return $this;
    }

    /**
     * Gets the resource path in the API request
     *
     * @return $this
     */
    public function getResource()
    {
        return $this->resource;
    }      

    /**
     * {@inheritdoc}
     */
    public function getStorageEngine()
    {
        return $this->api;
    }

    /**
     * {@inheritdoc}
     */
    public function setStorageEngine($storage)
    {
        $this->api = $storage;

        return $this;
    }    

    /**
     * {@inheritdoc}
     */
    public function findById($id)
    {
        return $this->api->get("/$this->resource/$id");
    }     

    /**
     * {@inheritdoc}
     */
    public function findByField(string $field, $value)
    {
        return $this->api->get("/$this->resource", [
            'limit' => 1,
            $field  => $value,
        ]);
    }        

    /**
     * {@inheritdoc}
     */
    public function where(string $field, $operator, $value = null) : Contracts\Repository
    {
        $this->query[$field] = $value;

        return $this;
    }    

    /**
     * {@inheritdoc}
     */
    public function whereIn(string $field, array $values) : Contracts\Repository
    {
        $this->query[$field] = $values;

        return $this;        
    }    

    /**
     * {@inheritdoc}
     */
    public function whereHasIn(string $field, array $values) : Contracts\Repository
    {
        // Not applicable to repository type

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function orderBy(string $field, string $direction) : Contracts\Repository
    {
        $this->query['orderBy'] = $field;

        $this->query['order'] = $direction;

        return $this;           
    }            

    /**
     * {@inheritdoc}
     */
    public function limit(int $limit) : Contracts\Repository
    {
        $this->query['limit'] = $limit;

        return $this;             
    }    

    /**
     * {@inheritdoc}
     */
    public function search(string $term = '') : Contracts\Repository
    {
        $this->query['q'] = $term;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function find() : iterable
    {
        $this->applyCriteria();
        
        return $this->api->get("/$this->resource", $this->query);
    }     

    /**
     * {@inheritdoc}
     */
    public function update($id, array $attributes)
    {
        return $this->api->patch("/$this->resource/$id", $attributes);
    }        

    /**
     * {@inheritdoc}
     */
    public function updateCollection(iterable $entities)
    {
        if (! $entities instanceof \Illuminate\Support\Collection) {
            $entities = new Collection($entities);
        }

        $responses = [];

        foreach ($entities->chunk(50) as $chunk) {

            $response = $this->api->patch("/$this->resource/collection", [
                $this->resource => $chunk,
            ]);

            $responses = array_merge_recursive($responses, $response->toArray());
        }

        return new Collection($responses);        
    }

    /**
     * {@inheritdoc}
     */
    public function delete($id)
    {
        return $this->api->delete("/$this->resource/$id");
    }     
}