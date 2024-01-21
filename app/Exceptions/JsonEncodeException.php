<?php

namespace App\Exceptions;

use Illuminate\Http\Response;

class JsonEncodeException extends ApplicationException
{
    public function status(): int
    {
        return Response::HTTP_BAD_REQUEST;
    }

    public function help(): string
    {
        return 'json not encoded';
    }

    public function error(): string
    {
        return 'json not encoded';
    }
}