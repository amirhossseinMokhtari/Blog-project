<?php

namespace App\Repositories;

use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class PostRepository
{
    /**
     * @return Collection
     */
    public function getAll($page)
    {
        if (Cache::tags(['posts', 'list'])->get('List-page-' . $page) == null) {
            $listPosts = Cache::tags(['posts', 'list'])->rememberForever('List-page-' . $page, function () {
                return DB::table('posts')->select('id', 'title', 'user_id', 'study_time_in_min', 'created_at')->whereNull('deleted_at')->orderBy('id', 'desc')->cursorPaginate(15);
            });
            return $listPosts;
        } else {

            $listPosts = Cache::tags(['posts', 'list'])->get('List-page-' . $page);
            Log::info('used-cache-for-getAll-list' . $page);
            return $listPosts;
        }

    }

    public function getById($id)
    {
        $cachedPost = Cache::tags(['post', 'detail-post-id-' . $id])->get('post-id-' . $id);
        if ($cachedPost) {
            $postDetail = json_decode($cachedPost);
            Log::info('used-cached-post-id-' . $id);
            return $postDetail;
        } else {
            $postDetail = Post::find($id);
            Cache::tags(['post', 'detail-post-id-' . $id])->add('post-id-' . $id, json_encode($postDetail));
            return $postDetail;
        }
//        $postDetails = Post::find($id);
    }

    public function create(Request $request)
    {
        $postData = array();
        $postData['user_id'] = $request->user_id;
        $postData['title'] = $request->title;
        $postData['body'] = $request->body;
        $postData['study_time_in_min'] = $request->study_time_in_min;
        $postData['created_at'] = Carbon::now();

        $newPost = $request->user()->posts()->create($postData);
        $id = $newPost->id;
        Cache::tags(['post', 'detail-post-id-' . $id])->add('post-id-' . $id, json_encode($newPost));
        return $newPost;
    }

    public function update($request, int $id)
    {
        $post = Post::find($id);
        Gate::authorize('modify', $post);
        $postUpdate = Post::find($post->id);
        $postUpdate->update($request->all());
        return $postUpdate;
    }

    public function deleted($id)
    {
        $post = Post::find($id);
        Gate::authorize('modify', $post);
        $postDelete = Post::where('id', $post->id)->first()->delete();
        return $postDelete;
    }

    public function getByAllUserId($userId)
    {

        $cachedPost = Cache::tags(['post', 'author-user-id-' . $userId])->get('posts-user-id-' . $userId);
        if ($cachedPost) {
            $AuthorPosts = $cachedPost;
            Log::info('used-cache-for-getAll-user-id' . $userId);
            return $AuthorPosts;
        } else {
            $AuthorPosts = DB::table('posts')->where('user_id', $userId)->select('id', 'title', 'user_id', 'study_time_in_min', 'created_at')
                ->whereNull('deleted_at')->orderBy('id', 'desc')->cursorPaginate(15);
            Cache::tags(['post', 'author-user-id-' . $userId])->add('posts-user-id-' . $userId, $AuthorPosts);
            return $AuthorPosts;
        }

    }
}
