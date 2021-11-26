<?php

namespace App\Tests\Support;

use App\Service\SendinBlueClient;

trait SendinBlueClientTrait
{
    private function getSendinBlueClientService(): SendinBlueClient
    {
        return static::getContainer()->get("test.App\Service\SendinBlueClient");
    }
}
