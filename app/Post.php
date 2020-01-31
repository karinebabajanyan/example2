<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title', 'description', 'image_upload','user_id'
    ];
    protected $dates = ['deleted_at'];

    public function users(){

        return $this->belongsTo('App\User','user_id','id');
    }
}
