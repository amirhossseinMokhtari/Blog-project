<?php

namespace App\Http\Controllers;

use App\Enums\HttpStatusCodes;
use App\Http\Requests\PostRequests\CreateRequestPost;
use App\Http\Requests\PostRequests\UpdateRequestPost;
use App\Http\Resources\PostResource;
use App\Repositories\PostRepository;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Response;

class PostController extends Controller implements HasMiddleware
{
    /**
     * @return Middleware[]
     */
    public static function middleware(): array
    {
        return [
            new Middleware('auth:sanctum', except: ['index', 'show'])
        ];
    }

    public PostRepository $postRepo;
    public function __construct(PostRepository $postRepo)
    {
        $this->postRepo = $postRepo;
    }


    public function getAll(): \Illuminate\Http\JsonResponse
    {
        $posts = $this->postRepo->getAll();
        if ($posts) {
            $postResource =PostResource::collection($posts);
            return response::json(['status' => ['message' => HttpStatusCodes::OK->message(), 'code' => HttpStatusCodes::OK->value], 'data' => $postResource]);
        } else {
            return Response::json(['status' => ['message' => HttpStatusCodes::NOT_FOUND->message(), 'code' => HttpStatusCodes::NOT_FOUND->value]]);
        }
    }


    public function getById(int $id)
    {
        $postDetail = $this->postRepo->getById($id);
        if ($postDetail) {
            $postResource = new PostResource($postDetail);
            return response::json(['status' => ['message' => HttpStatusCodes::OK->message(),
                'code' => HttpStatusCodes::OK->value], 'data' => $postResource]);
        } else {
            return Response::json(['status' => ['message' => HttpStatusCodes::NOT_FOUND->message(), 'code' => HttpStatusCodes::NOT_FOUND->value]]);
        }

    }


    public function create(CreateRequestPost $request)
    {
        $request->validated();
        $newPost = $this->postRepo->create($request);
        if ($newPost) {
            $postResource = new PostResource($newPost);
            return response::json(['status' => ['message' => HttpStatusCodes::CREATED->message(),
                'code' => HttpStatusCodes::CREATED->value], 'data' => $postResource]);
        } else {
            return Response::json(['status' => ['message' => HttpStatusCodes::NOT_FOUND->message(), 'code' => HttpStatusCodes::NOT_FOUND->value]]);
        }
    }


    public function update(UpdateRequestPost $request, int $id): \Illuminate\Http\JsonResponse
    {
        $request->validated();
        $postUpdate = $this->postRepo->update($request, $id);
        if ($postUpdate) {
            $postResource = new PostResource($postUpdate);
            return response::json(['status' => ['message' => HttpStatusCodes::OK->message(),
                'code' => HttpStatusCodes::OK->value], 'data' => $postResource]);
        } else {
            return Response::json(['status' => ['message' => HttpStatusCodes::NOT_FOUND->message(), 'code' => HttpStatusCodes::NOT_FOUND->value]]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(int $id): \Illuminate\Http\JsonResponse
    {
        $postDelete = $this->postRepo->delete($id);
        if ($postDelete) {
            return response::json(['status' => ['message' => HttpStatusCodes::OK->message(),
            'code' => HttpStatusCodes::OK->value]]);
        } else {
            return Response::json(['status' => ['message' => HttpStatusCodes::NOT_FOUND->message(), 'code' => HttpStatusCodes::NOT_FOUND->value]]);
        }
    }
}
