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

    // 1. Lấy toàn bộ kiện hàng và các bảng liên quan
    $query = Package::with(['order', 'consignmentOrder', 'delivery'])->orderByDesc('updated_at');
    
    if ($user->vai_tro === 'nhan_vien') {
        $query->where('tru_so_id', $user->warehouse_id);
    }
    
    $allPackages = $query->get();

    // 2. LỌC: Bỏ chặn trạng thái, chỉ xét vị trí Kho đích
    $filteredPackages = $allPackages->filter(function ($package) {
        
        // --- XÉT ĐƠN MUA HỘ ---
        if ($package->order_id && $package->order) {
            if ($package->tru_so_id == $package->order->tru_so_nhan_hang_id) {
                return true;
            }
        } 
        
        // --- XÉT ĐƠN KÝ GỬI ---
        elseif ($package->consignment_order_id && $package->consignmentOrder) {
            $co = $package->consignmentOrder;

            // Xác định kho đích linh hoạt theo chiều vận chuyển
            $khoDichId = ($co->chieu_van_chuyen === 'di_qt') 
                            ? $co->supplier_id // Chiều đi QT: Đích là Kho Quốc Tế
                            : $co->kho_vn_id;  // Chiều về VN: Đích là Kho VN

            if ($package->tru_so_id == $khoDichId) {
                return true;
            }
        }

        return false;
    });

    // 3. Lọc theo trạng thái giao hàng 
    if ($request->filled('trang_thai')) {
        $filteredPackages = $filteredPackages->filter(function ($package) use ($request) {
            if ($request->trang_thai === 'cho_giao') {
                return is_null($package->delivery);
            }
            return $package->delivery && $package->delivery->trang_thai === $request->trang_thai;
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

    // 3. Cập nhật trạng thái giao hàng 
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

        // KHI GIAO THÀNH CÔNG: TÍNH TIỀN PHẠT VÀ CHỐT ĐƠN
        if ($request->trang_thai === 'thanh_cong' && $trangThaiCu !== 'thanh_cong') {
            
            // 1. Tính tiền phạt từ thuộc tính ảo bên Model (Delivery)
            $tienPhat = $delivery->phu_phi_tre_han; 
            $motaTracking = "Kiện hàng đã được giao thành công đến tay khách hàng.";
            $ghiChuPhat = "";

            if ($tienPhat > 0) {
                // Tạo chuỗi ghi chú thông báo tiền phạt
                $ghiChuPhat = " [Hệ thống tự động cộng " . number_format($tienPhat) . "đ phí lưu kho do trễ " . $delivery->so_ngay_tre . " ngày]";
                
                // Cộng dồn tiền và nối thêm ghi chú
                $package->update([
                    'tinh_trang' => 'hoan_thanh',
                    'phi_khac'   => ($package->phi_khac ?? 0) + $tienPhat,
                    'thanh_tien' => ($package->thanh_tien ?? 0) + $tienPhat,
                    'ghi_chu'    => $package->ghi_chu ? $package->ghi_chu . $ghiChuPhat : ltrim($ghiChuPhat)
                ]);

                // Đính kèm thông báo phạt vào Tracking để dễ đối soát
                $motaTracking .= " Đơn hàng bị tính phụ phí lưu kho " . number_format($tienPhat) . "đ.";
            } else {
                // Nếu không bị phạt thì cập nhật bình thường
                $package->update(['tinh_trang' => 'hoan_thanh']);
            }
            
            // 2. Lưu lịch sử hành trình
            PackageTracking::create([
                'package_id'   => $package->id,
                'warehouse_id' => $package->tru_so_id,
                'employee_id'  => Auth::id(),
                'title'        => 'Giao hàng thành công',
                'description'  => $motaTracking,
            ]);

            // 3. TỰ ĐỘNG CẬP NHẬT TRẠNG THÁI THANH TOÁN CHO ĐƠN HÀNG CHA
            if ($package->order_id) {
                $order = $package->order;
                if ($order && $order->trang_thai_thanh_toan !== 'da_thanh_toan') {
                    $order->update([
                        'trang_thai_thanh_toan' => 'da_thanh_toan',
                        'ngay_thanh_toan'       => now(),
                    ]);
                }
            } elseif ($package->consignment_order_id) {
                $consignmentOrder = $package->consignmentOrder;
                if ($consignmentOrder && $consignmentOrder->trang_thai_thanh_toan !== 'da_thanh_toan') {
                    $consignmentOrder->update([
                        'trang_thai_thanh_toan' => 'da_thanh_toan',
                        'ngay_thanh_toan'       => now(),
                    ]);
                }
            }
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