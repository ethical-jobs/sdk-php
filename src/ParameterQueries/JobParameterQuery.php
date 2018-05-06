<?php

namespace EthicalJobs\SDK;

use EthicalJobs\Foundation\Http\ParameterQuery

/**
 * Job parameter query
 *
 * @author Andrew McLagan <andrew@ethicaljobs.com.au>
 */

class JobParameterQuery implements ParameterQuery
{
	/**
	 * Response array
	 *
	 * @var Illuminate\Support\Collection
	 */
	protected $response = [];

	/**
	 * Object constructor
	 *
	 * @param iterable $response
	 * @return void
	 */
	private function __construct(iterable $response)
	{
		$this->setResponse($response);
	}	

	/**
	 * Sets the current response array
	 *
	 * @param iterable $response
	 * @return $this
	 */
	public function setResponse(iterable $response): ResponseSelector
	{
		if (! $response instanceof Collection) {
			$response = collect($response);
		}

		$this->response = $response;

		return $this;
	}

	/**
	 * Gets the current response
	 *
	 * @return Illuminate\Support\Collection
	 */
	public function getResponse(): Collection
	{
		return $this->response;
	}		

	/**
	 * Static class instantiation
	 *
	 * @param iterable $response
	 * @return $this
	 */
	public static function select(iterable $response): ResponseSelector
	{
		return new static($response);
	}		

	/**
	 * Returns an entity by current response result
	 *
	 * @param string $entity
	 * @return array
	 */
	public function entityByResult(string $entity): array
	{
		$result = array_get($this->response, "data.result", '');

		return array_get($this->response, "data.entities.$entity.$result", []);
	}

	/**
	 * Returns an entity by id
	 *
	 * @param string $entity
	 * @param int $id
	 * @return array
	 */
	public function entityById(string $entity, int $id): array
	{
		return array_get($this->response, "data.entities.$entity.$id", []);
	}	

	/**
	 * Returns taxonomy term by id from app-data response
	 *
	 * @param string $taxonomy
	 * @param int $id
	 * @return array
	 */
	public function taxonomyTermById(string $taxonomy, int $id): array
	{
		return array_get($this->response, "data.taxonomies.$taxonomy.$id", []);
	}		

	/**
	 * Returns an entitites array
	 *
	 * @param string $entities
	 * @return array
	 */
	public function entities(string $entities): array
	{
		return array_get($this->response, "data.entities.$entities", []);
	}		

	/**
	 * 
	 */
	public function entitiesByDateFrom	

	public function entitiesByDateFrom
}