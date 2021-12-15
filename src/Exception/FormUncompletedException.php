<?php

namespace App\Exception;

use App\Entity\User;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class FormUncompletedException extends AccessDeniedException
{
    private $user;

    public const MESSAGE = "L'utilisateur a indiqué vouloir participer et ne peut donc pas se désister";

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
