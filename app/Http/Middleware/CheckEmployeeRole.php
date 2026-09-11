<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckEmployeeRole
{
   // Biến $roles sẽ nhận danh sách các vai trò được phép truy cập
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $employee = Auth::guard('employee')->user();

        // Nếu nhân viên chưa đăng nhập, hoặc vai trò không nằm trong danh sách cho phép -> Chặn
        if (!$employee || !in_array($employee->vai_tro, $roles)) {
            abort(403, 'Bạn không có quyền (vai trò) để truy cập khu vực này!');
        }

        return $next($request);
    }
}