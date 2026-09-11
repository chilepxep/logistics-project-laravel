<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //1 hiển thị form đăng nhập
    public function showLoginForm()
    {
        //nếu đã đăng nhập thì đá thẳng vô trang chủ Admin
        if(Auth::guard('employee')->check()){
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login');
    }

    //2 xử lý đăng nhập
    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $credentials = $request->only('email', 'password');

        // Sử dụng guard('employee') để xác thực
        if (Auth::guard('employee')->attempt($credentials, $request->filled('remember'))) {
            
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }
        return back()->withErrors([
            'email' => 'Email hoặc mật khẩu không chính xác.',
        ])->onlyInput('email');
    }

    //3 Đăng xuất
    public function logout(Request $request)
    {
        Auth::guard('employee')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }

    
}