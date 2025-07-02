<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class SysUser extends Authenticatable
{


    public $timestamps = false;
    
    protected $fillable = [
        'username',
        'password'
    ];

    protected $hidden = [
        'password',
    ];
}