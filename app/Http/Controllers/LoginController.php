<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AuthenticationRequest;

class LoginController extends Controller
{
    public function login(AuthenticationRequest $request)
    {
        $cridential = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($cridential, true)) {
            $user = Auth::user();

            $response = [
                'status_code' => 200,
                'status' => 'success',
                'data' => [
                    'token' => $user->createToken('saurav')->plainTextToken,
                    'name' => $user->name
                ],

                'message' => 'Login Successfully!'
            ];

            return response()->json($response, 200);
        } else {
            $response = [
                'status_code' => 401,
                'status' => 'error',
                'data' => null,

                'message' => 'Unauthorized!'
            ];

            return response()->json($response, 401);
        }
    }
}
