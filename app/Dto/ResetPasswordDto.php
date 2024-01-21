<?php

namespace App\Dto;

class ResetPasswordDto
{
    public string $email;

    public string $code;

    public string $password;

    public function __construct(string $email, string $password, string $code)
    {
        $this->email = $email;
        $this->password = $password;
        $this->code = $code;
    }
}
