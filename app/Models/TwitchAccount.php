<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TwitchAccount extends Model
{
    protected $fillable = [
        'user_id',
        'login_id',
        'name',
        'email',
        'avatar',
        'access_token',
        'refresh_token',
    ];

    protected $primaryKey = 'login_id';
    protected $keyType = 'string';
}