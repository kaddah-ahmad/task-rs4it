<?php

namespace App\Dto;

class ForgetPasswordDto
{
    public string $email;

    public function __construct(string $email)
    {
        $this->email = $email;
    }
}
