<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
    	// basic controller testing example
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        // controller assert testing
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Welcome to Symfony', $crawler->filter('#container h1')->text());

        // end testing
    }

    public function testSampleCode() 
    {
    	// another function goes here
    }
}
