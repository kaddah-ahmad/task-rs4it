<?php

namespace App\Exceptions;

use Illuminate\Http\Response;

class CredentialsIncorrectException extends ApplicationException
{
    public function status(): int
    {
        return Response::HTTP_FORBIDDEN;
    }

    public function help(): string
    {
        return 'email or password is wrong';
    }

    public function error(): string
    {
        return 'email or password is wrong';
    }
}
