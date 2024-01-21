<?php

namespace App\Ports;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;


interface IUserRepository 
{
    public function findByEmail(string $email, array $columns = ['*'], $relations = []): ?Model;

    public function findByUsername(string $username, array $columns = ['*'], $relations = []): ?Model;
}