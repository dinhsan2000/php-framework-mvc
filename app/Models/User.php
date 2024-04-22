<?php

namespace App\Models;

use Application\Database\Model;

class User extends Model
{
    protected string $table = 'users';
    protected array $fillable = [
        'name', 'email', 'password'
    ];
}