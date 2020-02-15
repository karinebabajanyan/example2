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
        'name',
        'email',
        'password',
        'confirmed_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the posts of the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function posts() {
        return $this->hasMany('App\Post','user_id', 'id');
    }

    /**
     * Get the posts of the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function identities() {
        return $this->hasMany('App\SocialIdentity');
    }

    /**
     * Get user's images.
     */
    public function files() {
        return $this->morphMany('App\File', 'fileable');
    }

    /**
     * Get user's cover photo.
     */
    public function cover_image() {
        return $this->morphOne('App\File', 'fileable')->where('category', 'cover');
    }
}
