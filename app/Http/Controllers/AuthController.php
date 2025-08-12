<?php

namespace App\Http\Controllers;

use App\Enums\HttpStatusCodes;
use App\Http\Requests\UserRequests\LoginRequestUser;
use App\Http\Requests\UserRequests\RegisterRequestUser;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class AuthController extends Controller
{
    public UserRepository $userRepositories;

    public function __construct(UserRepository $userRepositories)
    {
        $this->userRepositories = $userRepositories;
    }

    public function register(RegisterRequestUser $request)
    {
        $request->validated();
        $user = $this->userRepositories->register($request);
        $userResource = new UserResource($user);

        if ($userResource) {
            return response::json(['status' => ['message' => HttpStatusCodes::CREATED->message(),
                'code' => HttpStatusCodes::CREATED->value], 'data' => $userResource]);
        } else {
            return Response::json(['status' => ['message' => HttpStatusCodes::NON_AUTHORITATIVE->message(), 'code' => HttpStatusCodes::NON_AUTHORITATIVE->value]]);
        }
    }

    public function login(LoginRequestUser $request)
    {
        $request->validated();
        $user = $this->userRepositories->login($request);
        if ($user['status'] === HttpStatusCodes::OK) {
            $userResource = new UserResource($user);
            return response::json(['status' => ['message' => HttpStatusCodes::OK->message(),
                'code' => HttpStatusCodes::OK->value], 'data' => $userResource]);
        } elseif ($user['status'] === HttpStatusCodes::UNAUTHORIZED) {
            return Response::json(['status' => ['message' => HttpStatusCodes::UNAUTHORIZED->message(), 'code' => HttpStatusCodes::UNAUTHORIZED->value]]);
        } else {
            return Response::json(['status' => ['message' => HttpStatusCodes::NOT_FOUND->message(), 'code' => HttpStatusCodes::NOT_FOUND->value]]);
        }
    }


    public function logout(Request $request)
    {
        $user = $this->userRepositories->logout($request);
        if ($user['status'] === HttpStatusCodes::OK) {
            return response::json(['status' => ['message' => HttpStatusCodes::OK->message(),
                'code' => HttpStatusCodes::OK->value]]);
        } else {
            return Response::json(['status' => ['message' => HttpStatusCodes::NOT_FOUND->message(), 'code' => HttpStatusCodes::NOT_FOUND->value]]);
        }
    }

}
