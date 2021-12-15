<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\File;

class FileTo64 extends File
{
    public function __construct($path)
    {
        parent::__construct($path);
    }

    public function getBase64(): string
    {
        $type = pathinfo($this->getFilename(), PATHINFO_EXTENSION);
        $data = file_get_contents($this->getPathname());
        return base64_encode($data);
    }
}
