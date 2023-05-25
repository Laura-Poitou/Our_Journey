<?php

namespace App\Tests\Service;


use App\Service\restCountriesAPI;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class restCountriesAPITest extends KernelTestCase
{
    /**
     * fetch()
     */
    public function testFetch()
    {
        // (1) boot the Symfony kernel
        self::bootKernel();

        // (2) use static::getContainer() to access the service container
        $container = static::getContainer();

        // (3) run some service & test the result 
        $omdbApi = $container->get(restCountriesAPI::class);
        
        // call fetch('france') method to retrieve country JSON
        $result = $omdbApi->fetch('france');
        // affirm that the result is an array
        $this->assertIsArray($result);
        // affirm that the key "name" is present
        $this->assertArrayHasKey('name', $result[0]);
        // affirm that value in key common is France
        $this->assertEquals('France', $result[0]['name']['common']);
    }
}