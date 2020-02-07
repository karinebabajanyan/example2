<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'image_upload','is_check','post_id'
    ];
    protected $dates = ['deleted_at'];

    public function posts(){
        return $this->belongsTo('App\Post','post_id','id');
    }
}
