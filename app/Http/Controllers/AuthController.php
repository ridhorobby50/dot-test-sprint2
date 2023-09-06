<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            "email"         => "required",
            "password"      => "required",
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json(['error' => $errors], 422);
        }

        try {
            $credentials = $request->only('email', 'password');
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json(compact('token'));

        // $isValidEmail = User::where(["email"  =>$request->input('email')])->first()->makeVisible("password");
        // if(!$isValidEmail){
        //     return response()->json(['message'  => "Username tidak valid"], 404);
        // }

        // $isValidPassword = Authenticate::comparePassword($credentials['password'], $isValidEmail->password);
        // if(!$isValidPassword){
        //     return response()->json(['message'  => "password tidak valid"], 404);
        // }
        // unset($isValidEmail->password);
        // $token = JWTAuth::fromUser($isValidEmail);

        // return response()->json(compact('token'));
    }
}
