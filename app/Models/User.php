<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    // ];
    protected $guarded = [];


    protected $hidden = [
        'id',
        'username',
        'phone',
        'role',
        'status',
        'password',
        'image',
        'remember_token',
    ];

    // Mutator
    public function setPasswordAttribute($password)
    {
        $this->attributes['password']= bcrypt($password);
    }

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
