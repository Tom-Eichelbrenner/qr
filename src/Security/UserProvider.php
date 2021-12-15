<?php

namespace App\Security;

use App\Entity\User;
use App\Service\SendinBlueClient;
use Sendinblue\Client\ApiException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;


class UserProvider implements UserProviderInterface
{
    private $sendinblueClient;

    public function __construct(SendinblueClient $sendinblueClient)
    {
        $this->sendinblueClient = $sendinblueClient;
    }

    /**
     * @param UserInterface $user
     *
     * @return UserInterface
     */
    public function refreshUser(UserInterface $user): UserInterface
    {
        return $user;
    }

    /**
     * @param string $class
     *
     * @return bool
     */
    public function supportsClass(string $class): bool
    {
        return User::class === $class;
    }


    public function __call($name, $arguments)
    {
        // TODO: Implement @method UserInterface loadUserByIdentifier(string $identifier)
    }

    /**
     * @throws ApiException
     */
    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        $user = $this->sendinblueClient->getContact($identifier);
        if ($user) {
            return $user;
        }
        throw new UserNotFoundException("User with identifier $identifier doesnt exist");
    }

    /**
     * @param string $username
     *
     * @return UserInterface
     * @throws ApiException
     */
    public function loadUserByUsername(string $username): UserInterface
    {
        return $this->loadUserByIdentifier($username);
        // TODO: Implement loadUserByUsername() method.
    }
}
