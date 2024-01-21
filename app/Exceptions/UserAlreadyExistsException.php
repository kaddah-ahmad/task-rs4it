<?php

namespace App\Exceptions;

use Illuminate\Http\Response;

class UserAlreadyExistsException extends ApplicationException
{
    public function status(): int
    {
        return Response::HTTP_CONFLICT;
    }

    public function help(): string
    {
        return 'email is duplicated';
    }

    public function error(): string
    {
        return 'email is duplicated';
    }
}