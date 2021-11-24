<?php

namespace App\Tests\Functional;

use App\Service\SendinBlueClient;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class SendinBlueClientTest extends KernelTestCase
{
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

    public function testUpdateContact()
    {
        /**
         * @var SendinBlueClient
         */
        $sendinBlueClient = static::getContainer()->get("test.App\Service\SendinBlueClient");
        $user = $sendinBlueClient->getContact(self::TEST_CONTACT);
        $this->assertNotNull($user, "The contact " . self::TEST_CONTACT . " should return a valud User");

        $initialValue = $user->getParticipation();
        $inversedValue = $user->getParticipation() === true ? false : true;
        $user->setParticipation($inversedValue);

        $sendinBlueClient->updateContact($user);

        // check if the user has really been updated with
        $controlUser = $sendinBlueClient->getContact(self::TEST_CONTACT);

        // reset the user
        $user->setParticipation($initialValue);
        $sendinBlueClient->updateContact($user);

        $this->assertEquals($inversedValue, $controlUser->getParticipation(), "The value of attributes PARTICIPATION should be $inversedValue : {$controlUser->getParticipation()} was found");
    }
}
