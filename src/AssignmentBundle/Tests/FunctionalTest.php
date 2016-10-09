<?php

namespace AssignmentBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FunctionalTest extends WebTestCase
{
    public function testShowPost()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/assignment1');

        $this->assertContains(
            "<button type=\"button\" value='del' class='but_del'>DEL</button>",
            $client->getResponse()->getContent()
        );
    }
}