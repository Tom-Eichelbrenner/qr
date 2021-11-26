<?php

namespace App\Tests\Functional;

use App\Entity\User;
use App\Form\UserType;
use App\Tests\Support\ConstantsClass;
use App\Tests\Support\SendinBlueClientTrait;
use PHPUnit\TextUI\XmlConfiguration\Constant;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Form\Test\TypeTestCase;

class UserTypeTest extends KernelTestCase
{
    use SendinBlueClientTrait;


    public const USER_FIELDS_STEP_1 = [
        'civility',
        'first_name',
        'last_name',
        'email',
        'phone',
        'image_right'
    ];

    protected function setUp(): void
    {
        static::bootKernel();
    }

    /**
     * Test the fields number when form is built with step one
     *
     * @return void
     */
    public function testStepOneFields()
    {
        $sendinBlueClient = $this->getSendinBlueClientService();

        $user = $sendinBlueClient->getContact(ConstantsClass::TEST_CONTACT);

        $factory = static::getContainer()->get('form.factory');

        $form = $factory->create(UserType::class, $user, [
            'step' => 1
        ]);

        $names = array_filter(
            array_map(function ($field) {
                return $field->getName();
            }, $form->all()),
            function ($field) {
                return !in_array($field, ["submit", "_token"]);
            }
        );

        $this->assertEquals(
            $expected = count(self::USER_FIELDS_STEP_1),
            $actual = count($names),
            "The form must contains $expected (actually $actual)"
        );
    }

    /**
     * Test the fields number when form is built with step two
     *
     * @return void
     */
    public function testStepTwoFields()
    {
    }

    private function getStepTwoExpectedFields(
        bool $hotel,
        string $hotelName,
        bool $pleniere1,
        bool $pleniere2,
        bool $diner,
    ): array {
        $fields = [];



        return $fields;
    }
}
