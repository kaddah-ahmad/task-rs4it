<?php

namespace App\Dto;

class ConfirmUserDto
{
    public string $email;

    public string $code;

    public function __construct(string $email, string $code)
    {
        $this->email = $email;
        $this->code = $code;
    }
}
