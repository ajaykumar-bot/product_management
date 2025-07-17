<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // login api
    public function login(LoginRequest $request)
    {
        try {
            if (Auth::attempt($request->only('email', 'password'))) {
                $user = User::find(Auth::user()->id);
                return response()->json([
                    'message' => 'Logged in Successfully',
                    '_token' => $user->createToken('api-token')->accessToken,
                    'user' => $user
                ]);
            }

            return response()->json(['message' => 'Invalid Credentials'], 401);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    // login form
    public function showLoginForm()
    {
        return view('login');
    }

    // validate token
    public function validateToken(Request $request)
    {
        try {
 
            $user = User::find(Auth::user()->id);
            if($user){
                return response()->json([
                    'success' => true,
                    'message' => 'Token is valid.',
                    'user' => $user
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired token.'
            ], 401);

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
