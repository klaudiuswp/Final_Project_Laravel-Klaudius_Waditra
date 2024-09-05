<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|exists:users,email',
            'password' => 'required|string',
        ],[
            'email.exists' => 'akun dengan email :input tidak ditemukkan'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'Gagal',
                'message' => $validator->errors(),
            ], 401);
        }

        $credentials = $request->only('email', 'password');

        $token = Auth::attempt($credentials);

        if (!$token) {
            return response()->json([
                'status' => 'Gagal',
                'message' => 'Salah Password',
            ], 401);
        }

        $user = Auth::user();
        return response()->json([
            'status' => 'success',
            'message' => 'Login successful',
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ],
                'token' => $token
            ],
        ],202);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'address' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'Gagal',
                'message' => $validator->errors(),
            ], 400);
        }
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'address' => $request->address,
        ]);

        // $token = Auth::guard('api')->login($user);
        return response()->json([
            'status' => 'success',
            'message' => 'User registered successfully',
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'created_at' => $user->created_at,
                    'updated_at' => $user->updated_at
                ]
            ]
        ],201);
    }

    public function logout()
    {
        $removeToken = JWTAuth::invalidate(JWTAuth::getToken());

        if ($removeToken) {

            return response()->json([
                'status' => 'Berhasil',
                'message' => 'Logout telah dilakukan',
            ]);
        };
    }
    public function remove_acc()
    {
        $user = Auth::guard('api')->user();

        if ($user) {
            if ($user->order()->exists()) {
                return response()->json([
                    'status' => 'Gagal',
                    'message' => 'Tidak datpat menghapus user karena masih memiliki data order'
                ], 400);
            }
            $removeToken = JWTAuth::invalidate(JWTAuth::getToken());

            if ($removeToken) {
                $user->delete();

                return response()->json([
                    'status' => 'Berhasil',
                    'message' => "User $user->name telah dihapus",
                ]);
            }
        }

        return response()->json([
            'status' => 'Gagal',
            'message' => "User tidak ditemukan",
        ]);
    }
}
