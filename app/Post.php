<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'user_id'
    ];
    protected $dates = ['deleted_at'];

    /**
     * Get the creator of the post.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function users(){
        return $this->belongsTo('App\User','user_id','id');
    }

    /**
     * Get post images.
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function images(){
        return $this->hasMany('App\Image','post_id', 'id');
    }

    /**
     * Get only trashed files.
     */
    public function trashed_images(){
        return $this->morphMany('App\File', 'fileable')->withTrashed();
    }

    /**
     * Get post's images.
     */
    public function files()
    {
        return $this->morphMany('App\File', 'fileable');
    }

    /**
     * Exclude all irrelevant data.
     **/
    public function getFillable()
    {
        return $this->fillable;
    }
}
