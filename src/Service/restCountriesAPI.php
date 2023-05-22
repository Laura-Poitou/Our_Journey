<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Connector to OMDB API
 */
class restCountriesAPI
{ 
    private $client;
    private $jwtManager;
    private $tokenStorageInterface;

    public function __construct(HttpClientInterface $client, TokenStorageInterface $tokenStorageInterface, JWTTokenManagerInterface $jwtManager)
    {
        $this->client = $client;
        $this->jwtManager = $jwtManager;
        $this->tokenStorageInterface = $tokenStorageInterface;
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
            "https://restcountries.com/v3.1/name/". $name, [
                'query' => [
                    'token' => $this->jwtManager->decode($this->tokenStorageInterface->getToken())
                ]
            ]
            
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
            "https://restcountries.com/v3.1/all?fields=name,translations,flags,latlng", [
                'query' => [
                    'token' => $this->jwtManager->decode($this->tokenStorageInterface->getToken())
                ]
            ]);

        $statusCode = $response->getStatusCode();
        // $contentType = $response->getHeaders()['content-type'][0];
        $content = $response->toArray();
        
        return $content;

    }
}