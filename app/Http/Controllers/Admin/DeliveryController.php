<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Delivery;
use App\Models\Package;
use App\Models\PackageTracking;
use Illuminate\Support\Facades\Auth;

class DeliveryController extends Controller
{

// 1. Hiển thị danh sách Kiện hàng chờ giao & Đã điều phối giao
public function index(Request $request)
{
    $user = Auth::user();

    // 1. Lấy toàn bộ kiện hàng và các bảng liên quan (Chỉ lấy hàng của nhân viên để tối ưu)
    $query = Package::with(['order', 'consignmentOrder', 'delivery'])->orderByDesc('updated_at');
    
    if ($user->vai_tro === 'nhan_vien') {
        $query->where('tru_so_id', $user->warehouse_id);
    }
    
    $allPackages = $query->get();

    // 2. DÙNG CHÍNH XÁC LOGIC CỦA BẠN ĐỂ LỌC (Collection Filter)
    $filteredPackages = $allPackages->filter(function ($package) {
        if ($package->order_id && $package->tru_so_id == $package->order->tru_so_nhan_hang_id) {
            return true;
        } elseif ($package->consignment_order_id && $package->tru_so_id == $package->consignmentOrder->kho_vn_id) {
            return true;
        }
        return false;
    });

    // 3. Lọc theo trạng thái giao hàng nếu có chọn trên Form
    if ($request->filled('trang_thai_giao')) {
        $filteredPackages = $filteredPackages->filter(function ($package) use ($request) {
            if ($request->trang_thai_giao === 'cho_giao') {
                return is_null($package->delivery);
            }
            return $package->delivery && $package->delivery->trang_thai === $request->trang_thai_giao;
        });
    }

    // 4. Tạo bộ Phân trang (Pagination) thủ công cho mảng đã lọc
    $perPage = 20;
    $currentPage = \Illuminate\Pagination\Paginator::resolveCurrentPage() ?: 1;
    $items = $filteredPackages->slice(($currentPage - 1) * $perPage, $perPage)->values();

    $packagesReadyForDelivery = new \Illuminate\Pagination\LengthAwarePaginator(
        $items, 
        $filteredPackages->count(), 
        $perPage, 
        $currentPage, 
        ['path' => \Illuminate\Pagination\Paginator::resolveCurrentPath()]
    );
    $packagesReadyForDelivery->appends($request->all());

    return view('admin.deliveries.index', compact('packagesReadyForDelivery'));
}

    // 2. Tạo hoặc Cập nhật thông tin điều phối (Từ Modal)
    public function store(Request $request)
    {
        $request->validate([
            'package_id'             => 'required|exists:packages,id',
            'phuong_thuc_van_chuyen' => 'required|string|max:50',
            'thong_tin_giao_hang'    => 'required|string',
        ]);

        Delivery::updateOrCreate(
            ['package_id' => $request->package_id],
            [
                'ngay_tao'               => now(),
                'phuong_thuc_van_chuyen' => $request->phuong_thuc_van_chuyen,
                'ma_van_don'             => $request->ma_van_don,
                'ma_vung_noi_dia'        => $request->ma_vung_noi_dia,
                'phuong_thuc_thanh_toan' => $request->phuong_thuc_thanh_toan,
                'thong_tin_giao_hang'    => $request->thong_tin_giao_hang,
                'trang_thai'             => 'dang_giao',
            ]
        );

        // Ghi tracking xuất kho
        $package = Package::find($request->package_id);
        PackageTracking::create([
            'package_id'   => $package->id,
            'warehouse_id' => $package->tru_so_id,
            'employee_id'  => Auth::id(),
            'title'        => 'Bắt đầu giao hàng nội địa',
            'description'  => "Đã bàn giao cho đơn vị: " . $request->phuong_thuc_van_chuyen . ". Mã VĐ: " . ($request->ma_van_don ?? 'Chưa có'),
        ]);

        // Cập nhật tình trạng kiện hàng cha
        $package->update(['tinh_trang' => 'dang_giao_hang']);

        return back()->with('success', 'Đã điều phối giao hàng thành công!');
    }

    // 3. Cập nhật trạng thái giao hàng (Ví dụ: Đổi thành Thành công)
    public function update(Request $request, $id)
    {
        $delivery = Delivery::findOrFail($id);
        $package = $delivery->package;

        // Phân quyền cho nhân viên
        if (Auth::user()->vai_tro === 'nhan_vien' && $package->tru_so_id != Auth::user()->warehouse_id) {
            abort(403, 'Bạn không có quyền thao tác trên đơn giao hàng này!');
        }

        $trangThaiCu = $delivery->trang_thai;
        
        $delivery->update([
            'trang_thai'             => $request->trang_thai,
            'ma_van_don'             => $request->ma_van_don ?? $delivery->ma_van_don,
            'ghi_chu'                => $request->ghi_chu ?? $delivery->ghi_chu,
            // Nếu cập nhật thành công, tự động chốt ngày giao xong
            'ngay_giao_xong'         => ($request->trang_thai === 'thanh_cong' && $trangThaiCu !== 'thanh_cong') ? now() : $delivery->ngay_giao_xong,
        ]);

        if ($request->trang_thai === 'thanh_cong' && $trangThaiCu !== 'thanh_cong') {
            $package->update(['tinh_trang' => 'hoan_thanh']);
            
            PackageTracking::create([
                'package_id'   => $package->id,
                'warehouse_id' => $package->tru_so_id,
                'employee_id'  => Auth::id(),
                'title'        => 'Giao hàng thành công',
                'description'  => "Kiện hàng đã được giao thành công đến tay khách hàng.",
            ]);
        }

        return back()->with('success', 'Cập nhật trạng thái giao hàng thành công!');
    }

    // 4. Xóa phiếu giao hàng (Hủy điều phối)
    public function destroy($id)
    {
        $delivery = Delivery::findOrFail($id);
        $package = $delivery->package;

        // Rollback trạng thái kiện hàng
        $package->update(['tinh_trang' => 'da_nhap_kho']); 

        PackageTracking::create([
            'package_id'   => $package->id,
            'warehouse_id' => $package->tru_so_id,
            'employee_id'  => Auth::id(),
            'title'        => 'Hủy điều phối giao hàng',
            'description'  => "Phiếu giao hàng nội địa đã bị hủy.",
        ]);

        $delivery->delete();

        return back()->with('success', 'Đã hủy phiếu giao hàng!');
    }
}