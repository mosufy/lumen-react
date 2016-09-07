<?php
/**
 * Class ElasticsearchService
 *
 * @date      7/9/2016
 * @author    Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

namespace App\Services;

use Elasticsearch\Client;

/**
 * Class ElasticsearchService
 *
 * Long description of class goes here. What is this for?
 *
 *  *
 * ```
 * // Example code goes here
 * ```
 *
 * @see  Display a link to the documentation for an element here
 * @link Display a hyperlink to a URL in the documentation here
 */
class ElasticsearchService
{
    protected $client;

    public function __construct(Client $client)
    {
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
