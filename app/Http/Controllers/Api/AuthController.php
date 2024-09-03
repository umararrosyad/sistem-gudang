<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // Menggunakan Validator facade
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        // Cek apakah validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation Error',
                'data' => $validator->errors()
            ], 422);
        }

        $user = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'data' => $user
        ], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
                'data' => null
            ], 401);
        }

        return $this->respondWithToken($token);
    }

    public function logout()
    {
        Auth::logout(); // Log out the user

        // Blacklist the token
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json(['status' => 'success', 'message' => 'Successfully logged out', 'data' => null]);
    }

    public function me()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'User profile retrieved successfully',
            'data' => Auth::user(),
        ]);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Token generated successfully',
            'data' => [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() . ' minutes' // Menambahkan satuan "minutes"
            ]
        ]);
    }
}
