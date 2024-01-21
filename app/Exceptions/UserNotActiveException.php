<?php

namespace App\Exceptions;

use Illuminate\Http\Response;

class UserNotActiveException extends ApplicationException
{
    public function status(): int
    {
        return Response::HTTP_FORBIDDEN;
    }

    public function help(): string
    {
        return 'user not active';
    }

    public function error(): string
    {
        return 'user not active';
    }
}