<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // 1. Đăng ký (API)
    public function register(Request $request)
    {
        // validate data
        $request->validate([
            'ho_ten'   => 'required|string|max:150',
            'email'    => 'required|string|email|max:150|unique:users,email',
            'sdt'      => 'required|string|max:20',
            'password' => 'required|string|min:6|confirmed',
        ]);
        do {
            $maTaiKhoan = 'HTKK'.mt_rand(100000, 999999);
        } while (User::where('ma_tai_khoan', $maTaiKhoan)->exists());

        $user = User::create([
            'ma_tai_khoan' => $maTaiKhoan,
            'ho_ten'       => $request->ho_ten,
            'email'        => $request->email,
            'sdt'          => $request->sdt,
            'password'     => Hash::make($request->password), 
            'so_du'        => 0,
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Đăng ký tài khoản thành công!',
            'data' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 201); // 201: Created
    }

    // 2. Đăng nhập (API)
    public function login(Request $request) 
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);


        $user = User::where('email', $request->email)->first();


        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Email hoặc mật khẩu không chính xác.'
            ], 401); // 401: Unauthorized
        }

        // Xóa các token cũ (nếu muốn user chỉ đăng nhập 1 thiết bị)
        // $user->tokens()->delete(); 

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Đăng nhập thành công!',
            'data' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 200); 
    }

    // 3. Đăng xuất (API)
    public function logout(Request $request) 
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Bạn đã đăng xuất thành công.'
        ], 200);
    }
}