<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Passport\HasApiTokens;
use App\Http\Controllers\API\Notifications\VerifyApiEmail;


use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
     use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'phone', 'user_type', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //Email verification logic for the API

    public function sendApiEmailVerificationNotification()
    {
    $this->notify(new VerifyApiEmail); // my notification
    }

    //one to many relationship with OauthAccessToken table

    public function AauthAcessToken(){
        return $this->hasMany('\App\OauthAccessToken');
    }

}
