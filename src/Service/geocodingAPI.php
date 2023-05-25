<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Connector to OMDB API
 */
class geocodingAPI
{ 
    private $client;
    private $apiKey;

    public function __construct(HttpClientInterface $client, string $apiKey)
    {
        $this->client = $client;
        $this->apiKey = $apiKey;
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
            "http://api.openweathermap.org/geo/1.0/direct?q=" . $name . "&limit=5", [
                'query' => [
                    'appid' => $this->apiKey,
                ]
            ]
            
        );
        // casts the response JSON content to a PHP array
         $content = $response->toArray();

        return $content;

    }
}