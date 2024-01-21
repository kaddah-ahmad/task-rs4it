<?php

namespace App\Exceptions;

use Illuminate\Http\Response;

class OTPInvalidexception extends ApplicationException
{
    public function status(): int
    {
        return Response::HTTP_CONFLICT;
    }

    public function help(): string
    {
        return 'otp code invalid';
    }

    public function error(): string
    {
        return 'otp code invalid';
    }
}