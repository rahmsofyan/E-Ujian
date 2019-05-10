<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */


    protected $fillable = [
        'idUser','name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function getPIC()
    {
        return $this->belongsTo('App\pic','idUser','idUser')->first();
    }

    public function namaMhs(){
        return $this->hasMany('App\nilaiMhs', 'idUser');
    }

    
}
