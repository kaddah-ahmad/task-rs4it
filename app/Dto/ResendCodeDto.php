<?php

namespace App\Dto;

class ResendCodeDto
{
    public string $email;

    public function __construct(string $email)
    {
        $this->email = $email;
    }
}
