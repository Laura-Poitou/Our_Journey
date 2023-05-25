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
    public function fetch(string $name): array
    {
        // call Rest Countries API for this country name
        $response = $this->client->request(
            // HTTP method
            'GET',
            // API endpoint
            "https://restcountries.com/v3.1/name/". $name
            
        );

        // gets the HTTP status code of the response
        $statusCode = $response->getStatusCode();
        // gets the HTTP headers as string[][] with the header names lower-cased
        $contentType = $response->getHeaders()['content-type'][0];
        // gets the response body as a string
        //$content = $response->getContent();
        // // casts the response JSON content to a PHP array
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
            "https://restcountries.com/v3.1/all?fields=name,translations,flags,latlng");

        $content = $response->toArray();
        
        return $content;

    }
}