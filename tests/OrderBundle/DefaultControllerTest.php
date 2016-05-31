<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{

    public function testGetOrderId()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/newOrder');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('The code to manage the order is: ', $crawler->filter('p')->text());
    }

}
