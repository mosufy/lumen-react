<?php
/**
 * Class ElasticsearchService
 *
 * @date      7/9/2016
 * @author    Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

namespace App\Services;

use Elasticsearch\ClientBuilder;
use GuzzleHttp\Client;

/**
 * Class ElasticsearchService
 *
 * Connection service to Elasticsearch.
 */
class ElasticsearchService
{
    protected $client;

    public function __construct()
    {
        $hostsEnv = env('ELASTICSEARCH_HOST', '10.1.2.100:9200');
        $hosts    = explode(',', $hostsEnv);

        $clientB = new ClientBuilder();
        $client  = $clientB->setHosts($hosts)->build();

        $this->client = $client;
    }

    /**
     * Index a single item
     *
     * @param array $parameters [index, type, id, body]
     * @return array
     */
    public function index(array $parameters)
    {
        return $this->client->index($parameters);
    }

    /**
     * Get a single item
     *
     * @param array $parameters [index, type, id]
     * @return array
     */
    public function get(array $parameters)
    {
        return $this->client->get($parameters);
    }

    /**
     * Update a single item
     *
     * @param array $parameters [index, type, id, body]
     * @return array
     */
    public function update(array $parameters)
    {
        return $this->client->update($parameters);
    }

    /**
     * Delete a single item
     *
     * @param array $parameters
     * @return array
     */
    public function delete(array $parameters)
    {
        return $this->client->delete($parameters);
    }

    /**
     * Delete entire index
     *
     * Currently there is no such delete index being supported.
     * Replace with direct CURL request to delete index.
     *
     * @param array $parameters
     * @return array
     */
    public function drop(array $parameters)
    {
        $index = $parameters['index'];

        $client = new Client();
        $client->delete('http://' . env('ELASTICSEARCH_HOST', '10.1.2.100:9200') . '/' . $index);
    }

    /**
     * Index multiple items
     *
     * This method normalises the 'bulk' method of the Elastic Search
     * Client to have a signature more similar to 'index'.
     *
     * @param array $collection [[index, type, id, body], [index, type, id, body]...]
     * @return array
     */
    public function indexMany(array $collection)
    {
        $parameters = [];

        foreach ($collection as $item) {
            $parameters['body'][] = [
                "index" => [
                    '_id'    => $item['id'],
                    '_index' => $item['index'],
                    '_type'  => $item['type'],
                ]
            ];
            $parameters['body'][] = $item['body'];
        }

        return $this->client->bulk($parameters);
    }

    /**
     * Search index
     *
     * @param array $parameters
     * @return array
     */
    public function search(array $parameters)
    {
        return $this->client->search($parameters);
    }
}
