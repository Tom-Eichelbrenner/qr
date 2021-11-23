<?php

namespace App\Tests\Functional;

use App\Service\SendinBlueClient;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class SendinBlueClientTest extends KernelTestCase
{
    public const TEST_CONTACT = "";
    /**
     * @var SendinblueClient
     */
    private $sendinblueClient;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->sendinBlueClient = static::getContainer()->get("test.App\Service\SendinBlueClient");
    }

    public function testGetContact()
    {
        $user = $this->sendinblueClient->getContact(self::TEST_CONTACT);

        $this->assertNotNull($user, "The contact " . self::TEST_CONTACT . " should return a valud User");
    }

    public function updateContact()
    {
        $user = $this->sendinblueClient->getContact(self::TEST_CONTACT);

        $this->assertNotNull($user, "The contact " . self::TEST_CONTACT . " should return a valud User");

        // TODO perform an update without change to check that works, update the contact and reset it
    }
}
