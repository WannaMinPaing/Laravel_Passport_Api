<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;

class AuthController extends Controller
{   
    public function register(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password =bcrypt($request->password);
        $user->save();
        $token = $user->createToken('Api Register Success')->accessToken;
        return response()->json([
            'result' => 1,
            'message' => 'success',
            'token' => $token
        ]);
    }

    public function login(Request $request)
    {
        $data = $request->only('email','password');
        if(Auth::attempt($data))
        {
            $user = Auth::user();
            $token = $user->createToken('Api login Success')->accessToken;
            return response()->json([
                'result' => 1,
                'message' => 'success',
                'token' => $token
            ]);
        }
        else
        {
            return response()->json([
                'result' => 0,
                'message' => 'fail',
            ]);
        }
    }

    public function profile()
    {
        $user = Auth::user();
        $data  = new UserResource($user);//single  
        //UserResource::collection($user);//Multi
        return response()->json([
            'result' => 1,
            'message' => 'success',
            'data' => $data
        ]);
    }

    public function logout()
    {
        // Auth::user()->token()->revote();
        // return response()->json([
        //     'result' => 1,
        //     'message' => 'success'
        // ]);
        Auth::user()->tokens->each(function($token, $key) {
            $token->delete();
        });
    
        return response()->json('Successfully logged out');
        
    }
    
}


//https://www.youtube.com/watch?v=h9RrU5q4XrU&list=PLOvEA8-W5LWmlXwhG3fEDZ8kPVZ2Ysu83&index=6