<?php

namespace App\Service;

use SendinBlue;

class SendinBlueClient
{
    public function __construct(string $sendinblueApiKey)
    {
        $this->config = SendinBlue\Client\Configuration::getDefaultConfiguration()
            ->setApiKey('api-key', $sendinblueApiKey);
    }
}
