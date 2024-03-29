<?php

declare(strict_types=1);

namespace EthicalJobs\SDK\Mappers;

use EthicalJobs\SDK\ApiClient;
use Illuminate\Support\Collection;

class TaxonomyMapper implements MapperInterface
{
    /**
     * @var ApiClient
     */
    private $client;

    /**
     * @var TaxonomyMapper|Collection
     */
    private $dictionary;

    /**
     * Object constructor
     *
     * @param
     */
    public function __construct(ApiClient $client)
    {
        $this->client = $client;
        $this->dictionary = $this->fetchTaxonomyDictionary();
    }

    /**
     * Fetches taxonomy dictionary from the query
     *
     * @return Collection
     */
    private function fetchTaxonomyDictionary(): Collection
    {
        $response = $this->client->appData();

        return new Collection(Arr::get($response, 'data.taxonomies')) ?? new Collection;
    }

    /**
     * {@inheritdoc}
     */
    public function map(int $taxonomyId, string $type): string
    {
        return $this->dictionary[$type][$taxonomyId]['title'] ?? '';
    }
}
