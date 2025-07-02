<?php

namespace App\Models;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class SysUser extends Authenticatable
{
    use HasApiTokens; // Add this line!

    public $timestamps = false;
    
    protected $fillable = [
        'username',
        'password'
    ];

    protected $hidden = [
        'password',
    ];
}