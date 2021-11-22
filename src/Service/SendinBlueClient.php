<?php

namespace App\Service;

use App\Entity\User;
use SendinBlue;
use Sendinblue\Client\ApiException;

class SendinBlueClient
{
    public function __construct(string $sendinblueApiKey)
    {
        $this->config = SendinBlue\Client\Configuration::getDefaultConfiguration()
            ->setApiKey('api-key', $sendinblueApiKey);
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
