<?php

namespace App\Repositories;

use App\Enums\HttpStatusCodes;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class UserRepository
{
    public function register(Request $request)
    {


        $userData = array();
        $userData['username'] = $request->username;
        $userData['email'] = $request->email;
        $userData['first_name'] = $request->first_name;
        $userData['last_name'] = $request->last_name;
        $userData['gender'] = $request->gender;
        $userData['phone'] = $request->phone;
        $userData['password'] = Hash::make($request->password);
        $userData['created_at'] = Carbon::now();
        // $new_post=DB::table('posts')->insert($post_data);
        $newUser = User::create($userData);
        $token = $newUser->createToken($request->username);
        return [
            'user' => $newUser,
            'token' => $token->plainTextToken
        ];
    }


    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return [
                'status' => HttpStatusCodes::NOT_FOUND
            ];
        }
        if (Hash::check($request->password, $user->password)) {
            $token = $user->createToken($user->username);
            return [
                'status' => HttpStatusCodes::OK,
                'user' => $user,
                'token' => $token->plainTextToken
            ];

        } else {
            return [
                'status' => HttpStatusCodes::UNAUTHORIZED
            ];
        }
    }


    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return [
            'status' => HttpStatusCodes::OK
        ];

    }
}
