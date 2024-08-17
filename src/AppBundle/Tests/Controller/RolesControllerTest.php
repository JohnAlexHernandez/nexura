<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RolesControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/roles');
    }

    public function testNew()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/roles/new');
    }

    public function testEdit()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/roles/new');
    }

    public function testDelete()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/roles/delete');
    }

}
