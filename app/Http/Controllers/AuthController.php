<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;

//use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

// use  Illuminate\Contracts\Auth\Authenticatable;

//use function Laravel\Prompts\error;

class AuthController extends Controller
{
    public function register()
    {
        $userData = array();
        $userData['username'] = "";
        $userData['email'] = "";
        $userData['first_name'] = "";
        $userData['last_name'] = "";
        $userData['gender'] = " ['male', 'female']";
        $userData['phone'] = "";
        $userData['password'] = "";
        return $userData;
    }


    public function registerPost(Request $request)
    {

        $request->validate([
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:7'
        ]);

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

        // if ($new_user) {
        // return Response::json(['massage'=> "Registration successfully"],201) ;
        // // return redirect()-> route('login');
        // }
        // else{
        //     return Response::json(['massage'=> 'Non-Authoritative information','massage1'=> @error('username')],203) ;
        // }
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required|min:7'
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return Response::json(['massage' => 'User with this email was not found'], 203);
        }
        //   dd($request->password, $user->password);
        if (Hash::check($request->password, $user->password)) {
            // return Response::json(['massage'=> 'login successfully'],200) ;
            $token = $user->createToken($user->username);
            $aaa = [
                'user' => $user,
                'token' => $token->plainTextToken
            ];

            return Response::json(['massage' => 'User with this email was not found'], 203);

            // $token = $user->createToken($request->device_name ?? 'default');
            //    return Response::json(["token"=>$token->plain_text_token]);
            //    return $token;
            //    Auth::login($user);
        } else {
            return Response::json(['massage' => 'User password entered is wrong'], 404);
        }
        // $login_data=Auth::Post([
        //     "email"=>$request,
        //     "password"=>Hash::make($request->password)
        // ]);

// dd($login_data);

        //   $post=Post::create($post_data);


    }


    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return [
            'massage' => 'you are logget out'
        ];

    }

}
