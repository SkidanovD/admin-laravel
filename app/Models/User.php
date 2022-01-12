<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'photo',
        'user_post',
        'email',
        'role',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function addRequestFields(array $data)
    {
        return [
            'first_name' => !empty($data['first_name']) ? $data['first_name'] : '',
            'last_name' => !empty($data['last_name']) ? $data['last_name'] : '',
            'photo' => !empty($data['photo']) ? $data['photo'] : '',
            'user_post' => !empty($data['user_post']) ? $data['user_post'] : '',
            'email' => !empty($data['email']) ? $data['email'] : '',
            'role' => !empty($data['role']) ? $data['role'] : 'user',
        ];
    }
}
