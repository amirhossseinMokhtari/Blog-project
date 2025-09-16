<?php

namespace App\Observers;

use App\Models\Post;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class PostObserver
{
    /**
     * Handle the Post "created" event.
     */
    public function created(Post $post): void
    {
        /*if dont used ->orderBy('id', 'desc')->cursorPaginate(15) in getAll function
        $page=ceil(($post->id)/15);
        Log::info('page'.$page );*/
        Cache::tags(['posts', 'list'])->flush();
        Cache::forget('posts-user-id-' . $post->user_id);

    }

    /**
     * Handle the Post "updated" event.
     */
    public function updated(Post $post): void
    {
        Cache::tags(['post', 'list'])->flush();
        Cache::forget('post-id-' . $post->id);
        Cache::forget('posts-user-id-' . $post->user_id);
        Log::info('flush-update-post-id' . $post->id);
    }

    /**
     * Handle the Post "deleted" event.
     */

    public function deleting(Post $post): void
    {
        Cache::tags(['post', 'list'])->flush();
        Cache::forget('posts-user-id-' . $post->user_id);
        Cache::forget('post-id-' . $post->id);
        Log::info('flush-delete-post-id' . $post->id);

    }


}
