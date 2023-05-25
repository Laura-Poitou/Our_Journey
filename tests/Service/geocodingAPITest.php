<?php

namespace App\Tests\Service;


use App\Service\geocodingAPI;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class geocodingAPITest extends KernelTestCase
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
        $geocodingAPI = $container->get(geocodingAPI::class);
        
        // call fetch('London') method to retrieve city JSON
        $result = $geocodingAPI->fetch('London');
        // affirm that the result is an array
        $this->assertIsArray($result);
        // affirm that the key "name" is present
        $this->assertArrayHasKey('name', $result[0]);
        // affirm that value in key common is France
        $this->assertEquals('London', $result[0]['name']);
    }
}