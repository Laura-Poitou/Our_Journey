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
     * Fetch country information
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
            
        );

        //get status code
        $statusCode = $response->getStatusCode();
        // get header
        $contentType = $response->getHeaders()['content-type'][0];
        // get content
        $content = $response->getContent();
        // transform to array
        $content = $response->toArray();
        
        return $content;

    }

    /**
     * Fetch all countries name
     * @return array Country data
     */
    public function fetchAll()
    {
        // call Rest Countries API for this country name
        $response = $this->client->request(
            // HTTP method
            'GET',
            // API endpoint
            "https://restcountries.com/v3.1/all?fields=name,translations",
            
        );

        //get status code
        $statusCode = $response->getStatusCode();
        // get header
        $contentType = $response->getHeaders()['content-type'][0];
        // get content
        $content = $response->getContent();
        // transform to array
        $content = $response->toArray();
        
        return $content;

    }
}