<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
   public function edit() {
    $user = Auth::user();
    return view('user.profile', compact('user'));
   }

public function update(Request $request)
    {
        $user = User::find(Auth::id());

        // Validate dữ liệu đầu vào
        $request->validate([
            'ho_ten'                    => 'required|string|max:100',
            'sdt'                       => 'nullable|string|max:20',
            'ngay_sinh'                 => 'nullable|date',
            'gioi_tinh'                 => 'nullable|in:nam,nu,khac',
            'dia_chi'                   => 'nullable|string|max:255',
            'tinh_thanh'                => 'nullable|string|max:100',
            'loai_van_chuyen_mac_dinh'  => 'nullable|string|max:50',
        ]);

        try {
            // Cập nhật các trường được phép
            $user->update([
                'ho_ten'                    => $request->ho_ten,
                'sdt'                       => $request->sdt,
                'ngay_sinh'                 => $request->ngay_sinh,
                'gioi_tinh'                 => $request->gioi_tinh,
                'dia_chi'                   => $request->dia_chi,
                'tinh_thanh'                => $request->tinh_thanh,
                'loai_van_chuyen_mac_dinh'  => $request->loai_van_chuyen_mac_dinh,
            ]);

            return back()->with('success', 'Cập nhật thông tin cá nhân thành công!');
        } catch (\Exception $e) {
            return back()->withErrors('Lỗi hệ thống: ' . $e->getMessage());
        }
    }

    public function editPassword()
    {
        return view('user.change-password');
    }

    // 4. Xử lý logic đổi mật khẩu
    public function updatePassword(Request $request)
    {
        // Validate form
        $request->validate([
            'current_password' => 'required',
            'new_password'     => 'required|min:6|confirmed', // Bắt buộc nhập lại mật khẩu mới phải khớp
        ], [
            'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại.',
            'new_password.required'     => 'Vui lòng nhập mật khẩu mới.',
            'new_password.min'          => 'Mật khẩu mới phải có ít nhất 6 ký tự.',
            'new_password.confirmed'    => 'Xác nhận mật khẩu mới không trùng khớp.',
        ]);

        $user = User::find(Auth::id());

        // Kiểm tra xem mật khẩu hiện tại khách nhập có đúng không
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không chính xác.']);
        }

        // Nếu đúng, tiến hành cập nhật mật khẩu mới
        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with('success', 'Đổi mật khẩu thành công! Hãy ghi nhớ mật khẩu mới của bạn.');
    }
}