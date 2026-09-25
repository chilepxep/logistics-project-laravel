<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckApprovedEmployee
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Kiểm tra xem user (Employee) đã đăng nhập chưa
        if (Auth::check()) {
            
            // Nếu đã đăng nhập nhưng cột is_approved = 0 (false)
            if (Auth::user()->is_approved == 0) {
                
                // 1. Ép đăng xuất ngay lập tức
                Auth::logout(); 
                
                // 2. Hủy phiên làm việc (Session) để xóa sạch lịch sử bộ nhớ tạm
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                // 3. Đá về trang Đăng nhập kèm thông báo lỗi
                return redirect()->route('login')->with('error', 'Tài khoản của bạn đang chờ Admin xét duyệt. Vui lòng liên hệ quản lý!');
            }
        }

        // Nếu tài khoản đã được duyệt (is_approved = 1), cho phép đi tiếp
        return $next($request);
    }
}