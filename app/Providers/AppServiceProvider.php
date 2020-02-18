<?php

namespace App\Providers;

use App\User;
use App\Observers\UserObserver;
use App\Post;
use App\Observers\PostObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Relations\Relation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        User::observe(UserObserver::class);
        Post::observe(PostObserver::class);

        Relation::morphMap([
            'users' => User::class,
            'posts' => Post::class
        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
