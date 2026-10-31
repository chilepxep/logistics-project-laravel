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


    $baseQuery = Delivery::whereHas('package', function ($packageQuery) use ($userId) {
        $packageQuery->where(function($q) use ($userId) {
            $q->whereHas('order', function ($orderQuery) use ($userId) {
                $orderQuery->where('user_id', $userId);
            })->orWhereHas('consignmentOrder', function ($consignmentQuery) use ($userId) {
                $consignmentQuery->where('user_id', $userId);
            });
        });
    });

    $summary = [];
    
    $summary['nhan_tai_kho'] = (clone $baseQuery)
        ->where('phuong_thuc_van_chuyen', 'LIKE', '%Khách nhận tại kho%')
        ->count();

    $summary['giao_tan_noi'] = (clone $baseQuery)
        ->where(function($q) {
            $q->where('phuong_thuc_van_chuyen', 'NOT LIKE', '%Khách nhận tại kho%')
              ->orWhereNull('phuong_thuc_van_chuyen'); 
        })->count();

    $listQuery = (clone $baseQuery)->with(['package.order', 'package.consignmentOrder']);

    if ($request->filled('phuong_thuc_van_chuyen')) {
        $listQuery->where('phuong_thuc_van_chuyen', $request->phuong_thuc_van_chuyen);
    }

    if ($request->filled('phuong_thuc_thanh_toan')) {
        $listQuery->where('phuong_thuc_thanh_toan', $request->phuong_thuc_thanh_toan);
    }

    if ($request->filled('trang_thai')) {
        $listQuery->where('trang_thai', $request->trang_thai);
    }

    $deliveries = $listQuery->orderBy('ngay_tao', 'desc')
        ->paginate(15)
        ->appends($request->all());

    return view('user.delivery-list', compact('deliveries', 'summary'));
}

    public function completed(\Illuminate\Http\Request $request)
{
    $userId = Auth::id();

    // Khởi tạo truy vấn, BẮT BUỘC lọc trạng thái 'thanh_cong'
    $query = Delivery::with('package')
        ->where('trang_thai', 'thanh_cong')
        ->whereHas('package', function ($packageQuery) use ($userId) {
            $packageQuery->where(function ($q) use ($userId) {
                $q->whereHas('order', function ($orderQuery) use ($userId) {
                    $orderQuery->where('user_id', $userId);
                })->orWhereHas('consignmentOrder', function ($consignmentQuery) use ($userId) {
                    $consignmentQuery->where('user_id', $userId);
                });
            });
        });

    // Chỉ giữ lại 2 bộ lọc phụ 
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