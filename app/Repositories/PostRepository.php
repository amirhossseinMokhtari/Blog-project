<?php

namespace App\Repositories;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class PostRepository
{
    /**
     * @return Collection
     */
    public function getAll()
    {
        return DB::table('posts')->whereNotNull('deleted_at')->get();
    }

    public function getById($id)
    {
        $postDetail = Post::find($id);
        return $postDetail;
//        if (!empty($postDetail)) {
//            return Response::json(HttpStatusCodes::OK->message(), HttpStatusCodes::OK->value, ['data' => $postDetail]);
//        } else {
//            return Response::json(HttpStatusCodes::NOT_FOUND->message(), HttpStatusCodes::NOT_FOUND->value);
//        }
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
        return $postUpdate;
        //   $post_update=Post::where('id', $post->id)->update($post_data);

//        if ($postUpdate) {
//            return Response::json(HttpStatusCodes::OK->message(), HttpStatusCodes::OK->value);
//        } else {
//            return Response::json(HttpStatusCodes::NOT_FOUND->message(), HttpStatusCodes::NOT_FOUND->value);
//        }
    }

    public function delete($id)
    {
        $post = Post::find($id);
        Gate::authorize('modify', $post);

        // $post_delete=DB::table('posts')->delete($id);
        // $post_delete=DB::table('posts')->where('id',$id)->delete($id);

        $postDelete = Post::where('id', $post->id)->delete();
        return $postDelete;

    }
}
