<?php

namespace App;

use Illuminate\Notifications\Notifiable;
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
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function posts(){

        return $this->hasMany('App\Post','user_id', 'id');
    }
    //$2y$10$uvyW7O.DfErmGX5F8KQ.SukF1wnCnTqI3gi0AuX3U/BZDIueupO1e
}
