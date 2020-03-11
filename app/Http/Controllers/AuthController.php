<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use Carbon\Carbon;
use DB;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();

            $token = $user->createToken('MyApp')->accessToken;

            return response()->json(
                [
                    'token' => $token,
                    'token_type' => 'Bearer',
                    'user'  => $user,
                ],
                200
            );
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }

    }//end login()


    public function logout(Request $request)
    {
        auth()->user()->tokens->each(function ($token, $key) {
            $token->delete();
        });
        return response()->json('Logged out successfully', 200);

    }


}//end class
