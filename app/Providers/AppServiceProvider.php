<?php

namespace App\Providers;

use App\Events\PostCreated;
use App\Listeners\SendPostCreated;
use App\Models\Post;
use App\Observers\PostObserver;
use App\Repositories\PostRepository;
use Illuminate\Support\Facades\Event;
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
        Event::listen(PostCreated::class, SendPostCreated::class);
    }
}
