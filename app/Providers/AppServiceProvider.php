<?php

namespace App\Providers;

use App\Models\Post;
use App\Observers\PostObserver;
use App\Repositories\PostRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->bind(PostRepository::class);
        Post::observe(PostObserver::class);
    }
}
