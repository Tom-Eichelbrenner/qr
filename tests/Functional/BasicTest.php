<?php

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BasicTest extends WebTestCase
{
    /**
     * Test that request to home returns code 200
     *
     * @return void
     */
    public function testRootUrl()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $this->assertResponseIsSuccessful("bad code returned");
    }

    public function testSum()
    {
    }
}
