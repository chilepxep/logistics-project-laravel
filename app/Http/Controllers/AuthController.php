<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //1.Hiển thị form đăng ký
    public function showRegister()
    {
        return view('auth.register');
    }

    //2. xử lý đăng ký
    public function register(Request $request){

        $request->validate([
            'ho_ten'   => 'required|string|max:150',
            'email'    => 'required|string|email|max:150|unique:users,email',
            'sdt'      => 'required|string|max:20',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'ho_ten.required'   => 'Vui lòng nhập họ và tên.',
            'email.required'    => 'Vui lòng nhập địa chỉ email.',
            'email.email'       => 'Địa chỉ email không đúng định dạng.',
            'email.unique'      => 'Email này đã được sử dụng.',
            'sdt.required'      => 'Vui lòng nhập số điện thoại.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.min'      => 'Mật khẩu phải có ít nhất 6 ký tự.',
            'password.confirmed'=> 'Mật khẩu xác nhận không khớp.',
        ]);

        do {
            $maTaiKhoan = 'HTKK'.mt_rand(100000, 999999);
        } while (User:: where('ma_tai_khoan',$maTaiKhoan)->exists());

        // Tạo User mới

         $user = User::create([
            'ma_tai_khoan' => $maTaiKhoan,
            'ho_ten'       => $request->ho_ten,
            'email'        => $request->email,
            'sdt'          => $request->sdt,
             'password'     => $request->password,
            //'password'     => Hash::make($request->password),
            'so_du'        => 0,
        ]);
        // Đăng nhập ngay sau khi đăng ký
        Auth::login($user);
        return redirect('/index')->with('success', 'Đăng ký tài khoản thành công! Mã tài khoản của bạn là: ' . $maTaiKhoan);
    }

    // 3. Hiển thị form Đăng nhập
    public function showLogin()
    {
        return view('auth.login');
    }

    // 4. xử lý đăng nhập
    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không đúng định dạng',
            'password.required' => 'Vui lòng nhập mật khẩu',
        ]);

        $remember = $request->filled('remember');

        if(Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended('/index')->with('success','Đăng nhập thành công!');
        }

        return back()->withErrors([
            'email' => 'Thông tin đăng nhập hoặc mật khẩu không chính xác.',
        ])->onlyInput('email');
    }

    //đăng xuất
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/index')->with('success', 'Bạn đã đăng xuất thành công.');
    }

}