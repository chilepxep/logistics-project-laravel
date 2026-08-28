<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Package;

class DeliveryController extends Controller
{
    public function index(Request $request)
    {
          $userId = Auth::id();

        // Lấy danh sách giao hàng thuộc về các kiện hàng của user
        $query = Delivery::with('package')
            ->whereHas('package', function ($packageQuery) use ($userId) {
                $packageQuery->whereHas('order', function ($orderQuery) use ($userId) {
                    $orderQuery->where('user_id', $userId);
                })->orWhereHas('consignmentOrder', function ($consignmentQuery) use ($userId) {
                    $consignmentQuery->where('user_id', $userId);
                });
            });

        // 2. Áp dụng các bộ lọc nếu người dùng có chọn
        if ($request->filled('phuong_thuc_van_chuyen')) {
            $query->where('phuong_thuc_van_chuyen', $request->phuong_thuc_van_chuyen);
        }

        if ($request->filled('phuong_thuc_thanh_toan')) {
            $query->where('phuong_thuc_thanh_toan', $request->phuong_thuc_thanh_toan);
        }

        if ($request->filled('trang_thai')) {
            $query->where('trang_thai', $request->trang_thai);
        }

        // 3. Thực thi truy vấn và lấy kết quả
        $deliveries = $query->orderBy('ngay_tao', 'desc')->get();

        return view('user.delivery-list', compact('deliveries'));
    }

    public function completed(\Illuminate\Http\Request $request)
    {
        $userId = Auth::id();

        // Khởi tạo truy vấn, BẮT BUỘC lọc trạng thái 'da_hoan_thanh'
        $query = Delivery::with('package')
            ->where('trang_thai', 'da_hoan_thanh')
            ->whereHas('package', function ($packageQuery) use ($userId) {
                $packageQuery->whereHas('order', function ($orderQuery) use ($userId) {
                    $orderQuery->where('user_id', $userId);
                })->orWhereHas('consignmentOrder', function ($consignmentQuery) use ($userId) {
                    $consignmentQuery->where('user_id', $userId);
                });
            });

        // Chỉ giữ lại 2 bộ lọc phụ (Bỏ lọc trạng thái vì mặc định là đã giao)
        if ($request->filled('phuong_thuc_van_chuyen')) {
            $query->where('phuong_thuc_van_chuyen', $request->phuong_thuc_van_chuyen);
        }

        if ($request->filled('phuong_thuc_thanh_toan')) {
            $query->where('phuong_thuc_thanh_toan', $request->phuong_thuc_thanh_toan);
        }

        $deliveries = $query->orderBy('ngay_tao', 'desc')->get();

        return view('user.delivery-completed', compact('deliveries'));
    }
    }