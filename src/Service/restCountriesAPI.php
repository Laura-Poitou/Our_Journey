<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Connector to OMDB API
 */
class restCountriesAPI
{ 
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Fetch all country information
     * @param string $name Country name
     * @return array Country data
     */
    public function fetch(string $name)
    {
        // call Rest Countries API for this country name
        $response = $this->client->request(
            // HTTP method
            'GET',
            // API endpoint
            "https://restcountries.com/v3.1/name/". $name,
            // options
            // [
            //     // GET parameters (query string)
            //     'query' => [
            //         'name' => $name, // n = the country name
            //     ]
            // ]
        );

        $statusCode = $response->getStatusCode();
        // $statusCode = 200
        $contentType = $response->getHeaders()['content-type'][0];
        // $contentType = 'application/json'
        $content = $response->getContent();
        // $content = '{"id":521583, "name":"symfony-docs", ...}'
        $content = $response->toArray();
        // $content = ['id' => 521583, 'name' => 'symfony-docs', ...]

        return $content;

    }
}