<?php

namespace App\Http\Controllers\Admin;
use Carbon\Carbon;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\ConsignmentOrder;
use App\Models\Complaint;
use App\Models\Package;
use App\Models\Transaction;
use App\Models\User;

class AdminController extends Controller
{
   public function dashboard()
    {
        $admin = Auth::guard('employee')->user();
        
        $now = Carbon::now();
        $currentMonth = $now->month;
        $currentYear = $now->year;

        // 1. TỔNG HỢP 4 THẺ BÀI (Có Fallback Dữ liệu mẫu)
        
        $stats = [
            // Doanh thu: Tổng tiền các đơn Order đã hoàn thành + Giao dịch nạp tiền 
            'doanh_thu_thang' => Order::whereMonth('created_at', $currentMonth)
                                      ->whereYear('created_at', $currentYear)
                                      ->where('trang_thai', 'hoan_thanh')
                                      ->sum('tong_tien') ?: 150500000,
            
            // Tổng đơn hàng = Đơn mua hộ + Đơn ký gửi
            'tong_don_hang' => (Order::count() + ConsignmentOrder::count()) ?: 1285,
            
            // Tổng Khách hàng
            'tong_khach_hang' => User::count() ?: 342,
            
            // Khiếu nại chờ xử lý
            'tong_khieu_nai' => Complaint::where('trang_thai', 'cho_xu_ly')->count() ?: 12
        ];

        // 2. BIỂU ĐỒ TĂNG TRƯỞNG (6 THÁNG GẦN NHẤT)
        $chartLabels = [];
        $chartOrders = [];
        $chartPackages = [];

        // Mảng dữ liệu ảo dự phòng cho 6 tháng
        $mockOrders = [120, 190, 250, 320, 280, 450];
        $mockPackages = [150, 230, 310, 380, 350, 520];

        for ($i = 5; $i >= 0; $i--) {
            $targetDate = Carbon::now()->subMonths($i);
            $chartLabels[] = 'Tháng ' . $targetDate->month;
            
            // Đếm số lượng Đơn mua hộ (Order) trong tháng
            $realOrderCount = Order::whereMonth('created_at', $targetDate->month)
                                   ->whereYear('created_at', $targetDate->year)
                                   ->count();
            
            // Đếm số lượng Kiện hàng (Package) trong tháng
            $realPackageCount = Package::whereMonth('created_at', $targetDate->month)
                                       ->whereYear('created_at', $targetDate->year)
                                       ->count();

            // Nếu không có data thật, chèn data ảo theo index (5 - $i để đi từ trái qua phải)
            $chartOrders[] = $realOrderCount > 0 ? $realOrderCount : $mockOrders[5 - $i];
            $chartPackages[] = $realPackageCount > 0 ? $realPackageCount : $mockPackages[5 - $i];
        }

        // 3. BIỂU ĐỒ TRÒN KHIẾU NẠI
        $choXuLy = Complaint::where('trang_thai', 'cho_xu_ly')->count();
        $dangXuLy = Complaint::where('trang_thai', 'dang_xu_ly')->count();
        $hoanThanh = Complaint::where('trang_thai', 'hoan_thanh')->count();
        $tongKhieuNai = $choXuLy + $dangXuLy + $hoanThanh;

        $chartData = [
            'thang'     => $chartLabels,
            'don_hang'  => $chartOrders,
            'kien_hang' => $chartPackages,
            'khieu_nai' => [
                // Nếu chưa có khiếu nại nào trong DB, lấy bộ số ảo
                'cho_xu_ly' => $tongKhieuNai > 0 ? $choXuLy : 15,
                'da_xu_ly'  => $tongKhieuNai > 0 ? $dangXuLy : 8,
                'hoan_thanh'=> $tongKhieuNai > 0 ? $hoanThanh : 42
            ]
        ];

        return view('admin.dashboard', compact('admin', 'stats', 'chartData'));
    }
}