<?php

namespace App\Repositories;

use App\Models\Post;
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
        if(Cache::tags(['posts','list'])->get('List-'.$page) == null){
            $listPost =  Cache::tags(['posts','list'])->rememberForever('List-'.$page, function(){
                return DB::table('posts')->select('id', 'title', 'user_id', 'study_time_in_min', 'created_at')->whereNull('deleted_at')->orderBy('id', 'desc')->cursorPaginate(15);
            });
            return $listPost;
        } else {

            $listPost = Cache::tags(['posts','list'])->get('List-'.$page);
            Log::info('used-cache-for-getAll-list'.$page);
        }
        return $listPost;

    }

    public function getById($id)
    {
        $cachedPost = Cache::tags(['posts','detail'])->get("post:{$id}");
        if ($cachedPost) {
            $postDetail = json_decode($cachedPost);
            Log::info('used-cached-post-id'.$id);
            return $postDetail;
        } else {
            $postDetail = Post::find($id);
            Cache::tags(['posts','detail'])->add("post:$id", json_encode($postDetail));
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
        Cache::tags(['posts','detail'])->add("post:$id", json_encode($newPost));
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

    public function delete($id)
    {
        $post = Post::find($id);
        Gate::authorize('modify', $post);
        $postDelete = Post::where('id', $post->id)->delete();
        return $postDelete;
    }
}
