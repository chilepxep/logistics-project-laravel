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

    //Lọc các kiện hàng đang nằm tại kho của nhân viên 
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

        $khoCu = $package->tru_so_id;
        $tinhTrangCu = $package->tinh_trang;
        $danhSachKhoVN = \App\Models\Warehouse::where('loai_kho', 'VN')->pluck('id')->toArray();

        $request->validate([
            'tinh_trang' => 'required|string',
            'tru_so_id'  => 'required|exists:warehouses,id',
            'ma_van_don' => 'required|string|max:50',
            'tong_kg'    => 'nullable|numeric|min:0',
            'tong_m3'    => 'nullable|numeric|min:0',
        ]);

        $khoDichId = null;
        if ($package->order_id) {
            $khoDichId = \App\Models\Order::find($package->order_id)->tru_so_nhan_hang_id ?? null;
        } elseif ($package->consignment_order_id) {
            $khoDichId = \App\Models\ConsignmentOrder::find($package->consignment_order_id)->kho_vn_id ?? null; 
        }

        $tinhTrangMoi = $request->tinh_trang;
        if ($request->tru_so_id == $khoDichId && $tinhTrangMoi == 'da_nhap_kho') {
            $tinhTrangMoi = 'hoan_thanh';
        }

        
        // 1. Dữ liệu cơ bản
        $updateData = [
            'ma_van_don' => $request->ma_van_don,
            'tinh_trang' => $tinhTrangMoi, 
            'tru_so_id'  => $request->tru_so_id,
            'loai_hang'  => $request->loai_hang,
            'ghi_chu'    => $request->ghi_chu,
        ];

        // 2. Admin hoặc Nhân viên kho VN mới được phép lưu
        if ($user->vai_tro === 'admin' || ($user->vai_tro === 'nhan_vien' && in_array($user->warehouse_id, $danhSachKhoVN))) {
            $updateData['tong_kg']                = $request->tong_kg;
            $updateData['tong_m3']                = $request->tong_m3;
            $updateData['phi_van_chuyen_noi_dia'] = $request->phi_van_chuyen_noi_dia ?? 0;
            $updateData['phi_khac']               = $request->phi_khac ?? 0;
            $updateData['chiet_khau']             = $request->chiet_khau ?? 0;
            $updateData['thanh_tien']             = $request->thanh_tien ?? 0;
        }

        // 3. Thực thi cập nhật
        $package->update($updateData);

        $tenKhoMoi = \App\Models\Warehouse::find($request->tru_so_id)->ten_kho ?? 'Kho không xác định';

        // 1. TỰ ĐỘNG SINH TRACKING
        $trackingTitle = null;
        $trackingDesc = "Cập nhật tự động lúc " . now()->format('H:i d/m/Y');

        if ($tinhTrangCu != $tinhTrangMoi) {
            switch ($tinhTrangMoi) {
                case 'hoan_thanh':
                    $trackingTitle = "Khách đã nhận hàng";
                    $trackingDesc = "Kiện hàng đã được giao thành công tới kho đích/khách hàng.";
                    break;
                case 'tra_hang':
                    $trackingTitle = "Yêu cầu trả hàng";
                    $trackingDesc = "Khách hàng yêu cầu trả lại kiện hàng này.";
                    break;
                case 'dang_van_chuyen':
                    $trackingTitle = "Đang luân chuyển (Quốc tế)";
                    $trackingDesc = "Kiện hàng bắt đầu di chuyển khỏi: " . $tenKhoMoi;
                    break;
                case 'dang_giao_hang':
                    $trackingTitle = "Đang giao hàng (Nội địa)";
                    $trackingDesc = "Shipper đang trên đường giao kiện hàng cho khách tại Việt Nam.";
                    break;
                case 'da_nhap_kho':
                    $trackingTitle = "Đã nhập kho";
                    $trackingDesc = "Kiện hàng đã được quét nhập vào kho: " . $tenKhoMoi;
                    break;
            }
        } 
        elseif ($khoCu != $request->tru_so_id && !in_array($tinhTrangMoi, ['hoan_thanh', 'tra_hang'])) {
            $trackingTitle = "Đến trạm trung chuyển";
            $trackingDesc = "Kiện hàng đã được nhân viên cập nhật vị trí tới: " . $tenKhoMoi;
        }

        if ($trackingTitle) {
            PackageTracking::create([
                'package_id'   => $package->id,
                'warehouse_id' => $request->tru_so_id,
                'employee_id'  => Auth::id(),
                'title'        => $trackingTitle,
                'description'  => $trackingDesc,
            ]);
        }


        // ĐỒNG BỘ ORDER 

        if ($khoCu != $request->tru_so_id) {
            if ($package->order_id) Order::where('id', $package->order_id)->update(['kho_hien_tai_id' => $request->tru_so_id]);
            if ($package->consignment_order_id) ConsignmentOrder::where('id', $package->consignment_order_id)->update(['kho_hien_tai_id' => $request->tru_so_id]);
        }

        $trangThaiHanhTrinh = ['dang_van_chuyen', 'dang_giao_hang', 'da_nhap_kho'];
        
        if ($package->order_id) {
            if (in_array($tinhTrangMoi, $trangThaiHanhTrinh)) {
                Order::where('id', $package->order_id)->where('trang_thai', '!=', 'hoan_thanh')->update(['trang_thai' => 'dang_giao_hang']);
            } elseif ($tinhTrangMoi == 'hoan_thanh') {
                $conThieu = Package::where('order_id', $package->order_id)->where('tinh_trang', '!=', 'hoan_thanh')->exists();
                if (!$conThieu) Order::where('id', $package->order_id)->update(['trang_thai' => 'hoan_thanh']);
            }
        }

        if ($package->consignment_order_id) {
            if (in_array($tinhTrangMoi, $trangThaiHanhTrinh)) {
                ConsignmentOrder::where('id', $package->consignment_order_id)->where('trang_thai', '!=', 'hoan_thanh')->update(['trang_thai' => 'dang_giao_hang']);
            } elseif ($tinhTrangMoi == 'hoan_thanh') {
                $conThieu = Package::where('consignment_order_id', $package->consignment_order_id)->where('tinh_trang', '!=', 'hoan_thanh')->exists();
                if (!$conThieu) ConsignmentOrder::where('id', $package->consignment_order_id)->update(['trang_thai' => 'hoan_thanh', 'ngay_nhan_hang' => now()]);
            }
        }

        return redirect()->route('admin.packages.show', $package->id)->with('success', 'Đã cập nhật kiện hàng và lộ trình thành công!');
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