<?php

namespace App\Tests\Functional;

use App\Tests\Support\ConstantsClass;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class BasicTest extends WebTestCase
{
    /**
     * Test that request with wrong token returns unauthorized
     *
     * @return void
     */
    public function testFirewallUnauthorized()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/je-participe/false-token');
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED, "bad request code returned UNAUTHORIZED (401) expected");
    }

    public function testFirewallHttpOk()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/je-participe/' . ConstantsClass::TEST_CONTACT);
        $this->assertResponseIsSuccessful("The request should return HTTP_OK (200)");
    }
}
