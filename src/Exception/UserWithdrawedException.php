<?php

namespace App\Exception;

use App\Entity\User;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class UserWithdrawedException extends AccessDeniedException
{
    private $user;

    public const MESSAGE = "L'utilisateur s'est désisté";

    public function __construct(User $user, string $message = 'Access Denied.', \Throwable $previous = null)
    {
        $this->user = $user;

        parent::__construct($message, $previous);
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
