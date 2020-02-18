<?php

namespace App\Observers;

use App\Post;

class PostObserver
{
    public function creating(Post $post)
    {
        $post->user_id = auth()->id();
    }

    public function created(Post $post)
    {
        //
    }

    public function updating(Post $post)
    {
        //
    }

    public function updated(Post $post)
    {
        //
    }

    public function saving(Post $post)
    {
        //
    }

    public function saved(Post $post)
    {
        //
    }

    public function deleting(Post $post)
    {
        //
    }

    public function deleted(Post $post)
    {
        //
    }

    public function restoring(Post $post)
    {
        //
    }

    public function restored(Post $post)
    {
        //
    }
}