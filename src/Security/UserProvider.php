<?php

namespace App\Security;

use App\Entity\User;
use App\Service\SendinBlueClient;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * @method UserInterface loadUserByIdentifier(string $identifier)
 */
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
    public function refreshUser(UserInterface $user)
    {
        return $user;
    }

    /**
     * @param string $class
     *
     * @return bool
     */
    public function supportsClass(string $class)
    {
        return User::class === $class;
    }

    /**
     * @param string $username
     *
     * @return UserInterface
     */
    public function loadUserByUsername(string $username)
    {
    }

    public function __call($name, $arguments)
    {
        // TODO: Implement @method UserInterface loadUserByIdentifier(string $identifier)
    }
    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        $user = $this->sendinblueClient->getContact($identifier);
        if ($user) {
            return $user;
        }
        throw new UserNotFoundException("User with identifier $identifier doesnt exist");
    }
}
