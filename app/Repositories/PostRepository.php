<?php

namespace App\Repositories;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redis;

class PostRepository
{
    /**
     * @return Collection
     */
    public function getAll()
    {
        $cachedPost=Redis::get("postList");
        if ($cachedPost) {
            $postList=json_decode($cachedPost);
        }else {
            $postList = DB::table('posts')->whereNull('deleted_at')->get();;
            Redis::setex("postList", 600, json_encode($postList));
        }
        return $postList;
    }

    public function getById($id)
    {
        $cachedPost=Redis::get("post:{$id}");
        if ($cachedPost) {
            $postDetails=json_decode($cachedPost);
        }else {
            $postDetails = Post::find($id);
            Redis::setex("post:$id", 86400, json_encode($postDetails));
        }
//        $postDetails = Post::find($id);
        return $postDetails;
    }

    public function create(Request $request)
    {
        $postData = array();
        $postData['user_id'] = $request->user_id;
        $postData['title'] = $request->title;
        $postData['body'] =$request->body;
        $postData['study_time_in_min'] = $request->study_time_in_min;
        $postData['created_at'] = Carbon::now();

//        $new_post=DB::table('posts')->insert($post_data);
        $newPost=$request->user()->posts()->create($postData);
        $id=$newPost->id;
        Redis::setex("post:$id", 86400 , json_encode($newPost));
        return $newPost;
    }

    public function update($request, int $id)
    {
        $post = Post::find($id);
        Gate::authorize('modify', $post);
        // $post_update=DB::table('posts')->where('id',$id)->update($request->all());
        // $post_detail=Post::find($id);
        $postUpdate = Post::find($post->id);
        $postUpdate->update($request->all());
        Redis::setex("post:$id", 86400 , json_encode($postUpdate));
        return $postUpdate;
    }

    public function delete($id)
    {
        $post = Post::find($id);
        Gate::authorize('modify', $post);
        // $post_delete=DB::table('posts')->delete($id);
        // $post_delete=DB::table('posts')->where('id',$id)->delete($id);
        $postDelete = Post::where('id', $post->id)->delete();
        Redis::del("post:$id");
        return $postDelete;
    }
}
