<?php

namespace App\Exceptions;

use Illuminate\Http\Response;

class CompetitionNotFoundException extends ApplicationException
{
    public function status(): int
    {
        return Response::HTTP_NOT_FOUND;
    }

    public function help(): string
    {
        return 'competition not found';
    }

    public function error(): string
    {
        return 'competition not found';
    }
}