<?php

namespace App\Tests\Functional;

use App\Service\SendinBlueClient;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class SendinBlueClientTest extends KernelTestCase
{
    public const TEST_CONTACT = "test_1234567890_token";

    protected function setUp(): void
    {
        self::bootKernel();
    }

    public function testGetContact()
    {
        /**
         * @var SendinBlueClient
         */
        $sendinBlueClient = static::getContainer()->get("test.App\Service\SendinBlueClient");
        $user = $sendinBlueClient->getContact(self::TEST_CONTACT);
        $this->assertNotNull($user, "The contact " . self::TEST_CONTACT . " should return a valud User");
    }

    public function updateContact()
    {
        /**
         * @var SendinBlueClient
         */
        $sendinBlueClient = static::getContainer()->get("test.App\Service\SendinBlueClient");
        $user = $sendinBlueClient->getContact(self::TEST_CONTACT);
        $this->assertNotNull($user, "The contact " . self::TEST_CONTACT . " should return a valud User");

        // TODO perform an update without change to check that works, update the contact and reset it
    }
}
