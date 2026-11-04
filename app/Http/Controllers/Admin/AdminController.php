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

        
$stats = [
    // Doanh thu: Tính tổng cột 'thanh_tien' của các kiện hàng (Package) trong tháng
    'doanh_thu_thang' => \App\Models\Package::whereMonth('created_at', $currentMonth)
                                            ->whereYear('created_at', $currentYear)
                                            // ->where('tinh_trang', 'hoan_thanh') 
                                            ->sum('thanh_tien') ?: 150500000,
    
    // Tổng kiện hàng: Đếm toàn bộ số lượng record trong bảng packages
    'tong_don_hang' => \App\Models\Package::count() ?: 1285,
    
    // Tổng Khách hàng (Giữ nguyên)
    'tong_khach_hang' => \App\Models\User::count() ?: 342,
    
    // Khiếu nại chờ xử lý (Giữ nguyên)
    'tong_khieu_nai' => \App\Models\Complaint::where('trang_thai', 'cho_xu_ly')->count() ?: 0
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