<?php

namespace App\Exceptions;

use Illuminate\Http\Response;

class InternalServerErrorException extends ApplicationException
{
    public function status(): int
    {
        return Response::HTTP_INTERNAL_SERVER_ERROR;
    }

    public function help(): string
    {
        return 'internal server error';
    }

    public function error(): string
    {
        return 'internal server error';
    }
}