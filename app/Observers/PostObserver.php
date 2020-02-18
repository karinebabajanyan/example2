<?php

namespace App\Observers;

use App\Post;

class PostObserver
{
    /**
     * Handle the Post "creating" event.
     *
     * @param  \App\Post  $post
     * @return void
     */
    public function creating(Post $post)
    {
        $post->user_id = auth()->id();
    }

    /**
     * Handle the Post "created" event.
     *
     * @param  \App\Post  $post
     * @return void
     */
    public function created(Post $post)
    {
        //
    }

    /**
     * Handle the Post "updating" event.
     *
     * @param  \App\Post  $post
     * @return void
     */
    public function updating(Post $post)
    {
        //
    }

    /**
     * Handle the Post "updated" event.
     *
     * @param  \App\Post  $post
     * @return void
     */
    public function updated(Post $post)
    {
        //
    }

    /**
     * Handle the Post "saving" event.
     *
     * @param  \App\Post  $post
     * @return void
     */
    public function saving(Post $post)
    {
        //
    }

    /**
     * Handle the Post "saved" event.
     *
     * @param  \App\Post  $post
     * @return void
     */
    public function saved(Post $post)
    {
        //
    }

    /**
     * Handle the Post "deleting" event.
     *
     * @param  \App\Post  $post
     * @return void
     */
    public function deleting(Post $post)
    {
        //
    }

    /**
     * Handle the Post "deleted" event.
     *
     * @param  \App\Post  $post
     * @return void
     */
    public function deleted(Post $post)
    {
        //
    }

    /**
     * Handle the Post "restoring" event.
     *
     * @param  \App\Post  $post
     * @return void
     */
    public function restoring(Post $post)
    {
        //
    }

    /**
     * Handle the Post "restored" event.
     *
     * @param  \App\Post  $post
     * @return void
     */
    public function restored(Post $post)
    {
        //
    }
}