<?php

namespace App\Http\Controllers;

use App\Enums\HttpStatusCodes;
use App\Http\Requests\CreateRequestPost;
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

//    public $postResource;
//    public function __construct(PostResource $postResource)
//    {
//        $this->postResource=$postResource;
//    }

    public function getAll(): \Illuminate\Http\JsonResponse
    {
        return $this->postRepo->getAll();
    }


    public function oneById(int $id): \Illuminate\Http\JsonResponse
    {
        return $this->postRepo->oneById($id);
    }


    public function create(CreateRequestPost $request): PostResource
    {
        $postData = $request->validated();
        $newPost = $this->postRepo->create($request);

//        return $this->postResource->create($newPost);
//        return PostResource::collection($newPost);

//        return response()->json($newPost);
        return new PostResource($newPost);
//        return PostResource::createResponse($newPost);
//        return PostResource::createResponse(new PostResource($newPost));
    }


    public function update($request, int $id): \Illuminate\Http\JsonResponse
    {
        return $this->postRepo->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(int $id): \Illuminate\Http\JsonResponse
    {
        return $this->postRepo->delete($id);
    }
}
