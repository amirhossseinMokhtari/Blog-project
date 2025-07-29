<?php

namespace App\Repositories;

use App\Enums\HttpStatusCodes;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Response;

class PostRepo
{
    public function getAll()
    {
        $posts = DB::table('posts')->whereNotNull('deleted_at')->get();
        // $posts=Post::all();

        if (!empty($posts)) {
            return Response::json(HttpStatusCodes::OK->message(), HttpStatusCodes::OK->value, ['data' => $posts]);
        } else {
            return Response::json(HttpStatusCodes::NOT_FOUND->message(), HttpStatusCodes::NOT_FOUND->value);
        }
    }

    public function oneById(int $id)
    {
        $postDetail = Post::find($id);
        if (!empty($postDetail)) {
            return Response::json(HttpStatusCodes::OK->message(), HttpStatusCodes::OK->value, ['data' => $postDetail]);
        } else {
            return Response::json(HttpStatusCodes::NOT_FOUND->message(), HttpStatusCodes::NOT_FOUND->value);
        }
    }

    public function create(Request $request)
    {
        $postData = array();
        $postData['user_id'] = $request->user_id;
        $postData['title'] = $request->title;
        $postData['content'] = $request->content;
        $postData['study_time_in_min'] = $request->study_time_in_min;
        $postData['created_at'] = Carbon::now();

        // $new_post=DB::table('posts')->insert($post_data);

        $newPost = $request->user()->posts()->create($postData);
        return $newPost;

    }

    public function update(Request $request, int $id)
    {
        $post = Post::find($id);
        Gate::authorize('modify', $post);
        //   $post_data=array();
        //   $post_data['user_id']=$request->user_id;
        //   $post_data['title']=$request->title;
        //   $post_data['body']=$request->content;
        //   $post_data['study_time_in_min']=$request->study_time_in_min;
        //   $post_data['updated_at']=Carbon::now();

        // $post_update=DB::table('posts')->where('id',$id)->update($request->all());

        // $post_detail=Post::find($id);
        $postUpdate = Post::find($post->id);
        $postUpdate->update($request->all());

        //   $post_update=Post::where('id', $post->id)->update($post_data);

        if ($postUpdate) {
            return Response::json(HttpStatusCodes::OK->message(), HttpStatusCodes::OK->value);
        } else {
            return Response::json(HttpStatusCodes::NOT_FOUND->message(), HttpStatusCodes::NOT_FOUND->value);
        }
    }

    public function delete(int $id)
    {
        $post = Post::find($id);
        Gate::authorize('modify', $post);

        // $post_delete=DB::table('posts')->delete($id);
        // $post_delete=DB::table('posts')->where('id',$id)->delete($id);

        $postDelete = Post::where('id', $post->id)->delete();
        if ($postDelete) {
            return Response::json(HttpStatusCodes::OK->message(), HttpStatusCodes::OK->value);
        } else {
            return Response::json(HttpStatusCodes::NOT_FOUND->message(), HttpStatusCodes::NOT_FOUND->value);
        }
    }
}
