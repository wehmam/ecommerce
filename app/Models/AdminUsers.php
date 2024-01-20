<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cartalyst\Sentinel\Users\EloquentUser;

class AdminUsers extends EloquentUser
{
    use HasFactory;
    protected $table = 'admin_users';

    protected $hidden = [
        'remember_token',
    ];
    protected $guarded = [];

    protected $fillable = [
        'email',
        'password',
        'last_name',
        'first_name',
    ];
}
