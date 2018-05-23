<?php

namespace EthicalJobs\SDK;

use EthicalJobs\SDK\Collection;

/**
 * Response selector - selects items from response collection
 *
 * @author Andrew McLagan <andrew@ethicaljobs.com.au>
 */

class ResponseSelector 
{
	/**
	 * Response array
	 *
	 * @var EthicalJobs\SDK\Collection
	 */
	protected $response = [];

	/**
	 * Object constructor
	 *
	 * @param iterable $response
	 * @return void
	 */
	public function __construct(iterable $response)
	{
		$this->setResponse($response);
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
	 * Sets the current response array
	 *
	 * @param iterable $response
	 * @return $this
	 */
	public function setResponse(iterable $response): ResponseSelector
	{
		if (! $response instanceof Collection) {
			$response = new Collection($response);
		}

		$this->response = $response;

		return $this;
	}

	/**
	 * Gets the current response
	 *
	 * @return EthicalJobs\SDK\Collection
	 */
	public function getResponse(): Collection
	{
		return $this->response;
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
	 * Returns response result array
	 *
	 * @return array|int
	 */
	public function result()
	{
		return array_get($this->response, "data.result", []);
	}		
}