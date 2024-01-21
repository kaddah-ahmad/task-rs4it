<?php

namespace App\Exceptions;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use JsonSerializable;

class Error implements Arrayable, Jsonable, JsonSerializable
{
    private string $help;
    private string $error;

    public function __construct(string $help, string $error)
    {
        $this->help = $help;
        $this->error = $error;
    }

    public function toArray()
    {
        return [
            'help' => $this->help,
            'error' => $this->error,
        ];
    }

    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }

    public function toJson($options = 0)
    {
        $jsonEncode = json_encode($this->jsonSerialize(), $options);
        throw_unless($jsonEncode, JsonEncodeException::class);
        return $jsonEncode;
    }
}
