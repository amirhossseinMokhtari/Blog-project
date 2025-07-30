<?php

namespace App\Http\Controllers;

use App\Enums\HttpStatusCodes;
use App\Http\Requests\CreateRequestPost;
use App\Http\Requests\DeleteRequestPost;
use App\Http\Requests\getByIdRequestPost;
use App\Http\Requests\UpdateRequestPost;
use App\Http\Resources\PostResource;
use App\Repositories\PostRepo;
use Carbon\Carbon;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('auth:sanctum', except: ['index', 'show'])
        ];
    }

    public $postRepo;

    public function __construct(PostRepo $postRepo)
    {
        $this->postRepo = $postRepo;
    }


    public function getAll(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $posts= $this->postRepo->getAll();
         return PostResource::collection($posts);
    }


    public function getById(GetByIdRequestPost $id): PostResource
    {
        $id = $id->validated();

        try {
        $postDetail= $this->postRepo->getById($id);
        return new PostResource($postDetail);
        }catch (\Exception $exception){
            return Response::json([HttpStatusCodes::NOT_FOUND->message(), HttpStatusCodes::NOT_FOUND->value]);
        }
    }


    public function create(CreateRequestPost $request): PostResource
    {
        $postData = $request->validated();
        try {
            $newPost = $this->postRepo->create($request);
            return new PostResource($newPost);
        }catch (\Exception $exception){
            return Response::json([HttpStatusCodes::NOT_FOUND->message(), HttpStatusCodes::NOT_FOUND->value]);
        }




//        return $this->postResource->create($newPost);
//        return PostResource::collection($newPost);
//        return response()->json($newPost);
//        return PostResource::createResponse($newPost);
//        return PostResource::createResponse(new PostResource($newPost));
    }


    public function update(UpdateRequestPost $request, int $id): PostResource
    {
        $postData = $request->validated();
        try {
        $postUpdate= $this->postRepo->update($request, $id);
        return new PostResource($postUpdate);
        }catch (\Exception $exception){
            return Response::json([HttpStatusCodes::NOT_FOUND->message(), HttpStatusCodes::NOT_FOUND->value]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(DeleteRequestPost $id): \Illuminate\Http\JsonResponse
    {
        $id = $id->validated();
        $postDelete= $this->postRepo->delete($id);
        if ($postDelete) {
            return Response::json(HttpStatusCodes::OK->message(), HttpStatusCodes::OK->value);
        } else {
            return Response::json(HttpStatusCodes::NOT_FOUND->message(), HttpStatusCodes::NOT_FOUND->value);
        }
    }
}
