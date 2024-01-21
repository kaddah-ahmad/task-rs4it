<?php

namespace App\Exceptions;

use Illuminate\Http\Response;

class UserNotFoundException extends ApplicationException
{
    public function status(): int
    {
        return Response::HTTP_NOT_FOUND;
    }

    public function help(): string
    {
        return 'user not found';
    }

    public function error(): string
    {
        return 'user not found';
    }
}