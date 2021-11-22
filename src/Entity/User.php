<?php

namespace App\Entity;

class User
{
    /**
     * Id in sendmail
     *
     * @var string
     */
    private $token;

    public function setToken(string $token)
    {
        $this->token = $token;
    }

    public function getToken(): string
    {
        return $this->token;
    }
}
