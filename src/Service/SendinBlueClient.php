<?php

namespace App\Service;

use App\Entity\User;
use SendinBlue;
use Sendinblue\Client\ApiException;

class SendinBlueClient
{
    /**
     * The id of the list the client can work with
     *
     * @var $sendinBlueApiKey
     * @var $sendinBlueListId
     */
    private $sendinBlueListId;

    public function __construct(string $sendinBlueApiKey, int $sendinBlueListId)
    {
        $this->config = SendinBlue\Client\Configuration::getDefaultConfiguration()
            ->setApiKey('api-key', $sendinBlueApiKey);

        $this->sendinBlueListId = $sendinBlueListId;
    }

    /**
     * Retreive a contact based on its token
     *
     * @param string $token
     *
     * @throws Sendinblue\ApiException
     *
     * @return User|null
     *
     */
    public function getContact(string $token): ?User
    {
        return null;
    }


    /**
     * Update the given contact in sendinblue contact database
     *
     * @param User $user
     *
     * @throws Sendinblue\ApiException
     *
     * @return User
     */
    public function updateContact(User $user): User
    {
        return $user;
    }

    /**
     * Map the array (sendinblue attributes) to a usable User entity
     *
     * @param array $attributes - sendinblue datas attributes
     *
     * @return \App\Entity\User
     */
    private function mapAttributesToUser(array $attributes): User
    {
        $user = new User();

        return $user;
    }
}
