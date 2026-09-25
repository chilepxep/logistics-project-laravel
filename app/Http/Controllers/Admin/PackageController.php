<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\Order;
use App\Models\ConsignmentOrder;
use App\Models\Warehouse;
use App\Models\PackageTracking;
use Illuminate\Support\Facades\Auth;

class PackageController extends Controller
{
    // 1. Danh sách kiện hàng
    public function index(Request $request)
{
    $user = Auth::user();
    $query = Package::with(['warehouse', 'order', 'consignmentOrder']);

    //Lọc các kiện hàng đang nằm tại kho của nhân viên (Có quyền sửa)
    if ($request->has('kho_cua_toi') && $user->vai_tro === 'nhan_vien') {
        $query->where('tru_so_id', $user->warehouse_id);
    }

    //Tìm kiếm theo mã vận đơn hoặc mã kiện
    if ($request->filled('keyword')) {
        $kw = $request->keyword;
        $query->where(function($q) use ($kw) {
            $q->where('ma_van_don', 'like', "%{$kw}%")
              ->orWhere('ma_don_kien_hang', 'like', "%{$kw}%");
        });
    }

    //Lọc theo trạng thái
    if ($request->filled('tinh_trang')) {
        $query->where('tinh_trang', $request->tinh_trang);
    }

    $packages = $query->orderByDesc('created_at')->paginate(20);
    
    
    $packages->appends($request->all());

    return view('admin.packages.index', compact('packages'));
}

    // 2. Chi tiết kiện hàng
    public function show($id)
    {
        $package = Package::with(['warehouse', 'order.user', 'consignmentOrder.user'])->findOrFail($id);
        return view('admin.packages.show', compact('package'));
    }

    //Form cập nhật thông tin kho
    public function edit($id)
    {
        $package = Package::findOrFail($id);
        $user = Auth::user();
        if ($user->vai_tro === 'nhan_vien' && $package->tru_so_id != $user->warehouse_id) {
        abort(403, 'Từ chối truy cập: Bạn chỉ được phép sửa các kiện hàng đang nằm tại kho của mình!');
    }
        $warehouses = Warehouse::all();
        return view('admin.packages.edit', compact('package', 'warehouses'));
    }

    // 4. Lưu cập nhật
    public function update(Request $request, $id)
    {
        $package = Package::findOrFail($id);
        $user = Auth::user();

        if ($user->vai_tro === 'nhan_vien' && $package->tru_so_id != $user->warehouse_id) {
        abort(403, 'Hành vi bị chặn: Bạn không có quyền cập nhật kiện hàng này!');
    }

        //Lưu lại vị trí cũ để so sánh xem có thực sự chuyển kho hay không
    $khoCu = $package->tru_so_id;

        $request->validate([
            'tinh_trang' => 'required|string',
            'tru_so_id'  => 'required|exists:warehouses,id',
            'ma_van_don' => 'required|string|max:50',
            'tong_kg'    => 'nullable|numeric|min:0',
            'tong_m3'    => 'nullable|numeric|min:0',
        ]);

        $package->update([
            'ma_van_don'             => $request->ma_van_don,
            'tinh_trang'             => $request->tinh_trang,
            'tru_so_id'              => $request->tru_so_id,
            'loai_hang'              => $request->loai_hang,
            'tong_kg'                => $request->tong_kg,
            'tong_m3'                => $request->tong_m3,
            'phi_van_chuyen_noi_dia' => $request->phi_van_chuyen_noi_dia ?? 0,
            'phi_khac'               => $request->phi_khac ?? 0,
            'chiet_khau'             => $request->chiet_khau ?? 0,
            'thanh_tien'             => $request->thanh_tien ?? 0,
            'ghi_chu'                => $request->ghi_chu,
        ]);

        // LOGIC TRACKING KHI THAY ĐỔI KHO BÃI
    if ($khoCu != $request->tru_so_id) {
        
        $tenKhoMoi = \App\Models\Warehouse::find($request->tru_so_id)->ten_kho ?? 'Kho không xác định';

        // 1. Ghi lại lịch sử Tracking cho kiện hàng này
        PackageTracking::create([
            'package_id'   => $package->id,
            'warehouse_id' => $request->tru_so_id,
            'employee_id'  => Auth::id(),
            'title'        => 'Đến trạm trung chuyển',
            'description'  => "Kiện hàng đã được nhân viên cập nhật vị trí tới: " . $tenKhoMoi,
        ]);

        // 2. Đồng bộ vị trí CẬP NHẬT NGƯỢC LÊN Đơn hàng Order / ConsignmentOrder
        if ($package->order_id) {
            Order::where('id', $package->order_id)->update(['kho_hien_tai_id' => $request->tru_so_id]);
        }
        if ($package->consignment_order_id) {
            ConsignmentOrder::where('id', $package->consignment_order_id)->update(['kho_hien_tai_id' => $request->tru_so_id]);
        }
    }

        //LOGIC KÍCH HOẠT TỰ ĐỘNG ĐÓNG ĐƠN KHI KIỆN HOÀN THÀN
        if ($request->tinh_trang == 'hoan_thanh') {
            
            // Nếu là kiện của Đơn mua hộ
            if ($package->order_id) {
                $conThieu = Package::where('order_id', $package->order_id)
                                   ->where('tinh_trang', '!=', 'hoan_thanh')
                                   ->exists();
                if (!$conThieu) {
                    Order::where('id', $package->order_id)->update(['trang_thai' => 'hoan_thanh']);
                }
            }
            
            // Nếu là kiện của Đơn ký gửi
            if ($package->consignment_order_id) {
                $conThieu = Package::where('consignment_order_id', $package->consignment_order_id)
                                   ->where('tinh_trang', '!=', 'hoan_thanh')
                                   ->exists();
                if (!$conThieu) {
                    ConsignmentOrder::where('id', $package->consignment_order_id)->update(['trang_thai' => 'hoan_thanh']);
                }
            }
        }

        return redirect()->route('admin.packages.show', $package->id)->with('success', 'Đã cập nhật kiện hàng thành công!');
    }

    // 5. Xóa kiện hàng
    public function destroy($id)
    {
        $package = Package::findOrFail($id);
        
        if ($package->tinh_trang == 'hoan_thanh') {
            return back()->withErrors('Không thể xoá kiện hàng đã hoàn thành!');
        }

        $package->delete();
        return redirect()->route('admin.packages.index')->with('success', 'Đã xoá kiện hàng!');
    }
}