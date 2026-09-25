<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ConsignmentOrder;
use App\Models\Warehouse;
use Illuminate\Support\Facades\DB;
use App\Models\ConsignmentOrderItem; 
use App\Models\ConsignmentExtraRequirement; 
use Illuminate\Support\Facades\Auth;
use App\Models\Package;
use App\Models\PackageTracking;

class ConsignmentOrderController extends Controller
{
    // 1. Danh sách đơn
    public function index(Request $request)
    {
       
        $query = ConsignmentOrder::query()->with(['user', 'khoVn', 'khoHienTai']);

       
        $employee = Auth::user();

        
        if ($employee->vai_tro === 'nhan_vien') {
            // Nhân viên chỉ thấy đơn hàng khi gói hàng ĐANG Ở KHO CỦA HỌ
            $query->where('kho_hien_tai_id', $employee->warehouse_id);
            
        } elseif ($employee->vai_tro !== 'admin') {
            // Bảo mật: Nếu tài khoản bị lỗi vai trò  thì không cho xem gì
            $query->where('id', 0);
        }
       

       
        if ($request->filled('trang_thai')) {
            $query->where('trang_thai', $request->trang_thai);
        }

        
        $orders = $query->orderByDesc('created_at')->paginate(15);
        
        return view('admin.consignment_orders.index', compact('orders'));
    }

    // 2. Chi tiết đơn
    public function show($id)
    {
        $order = ConsignmentOrder::with('user')->findOrFail($id);
        return view('admin.consignment_orders.show', compact('order'));
    }

    // 3. Form sửa đơn
    public function edit($id)
    {
        $order = ConsignmentOrder::with(['items', 'extraRequirements'])->findOrFail($id);
    $countries = \App\Models\Country::all();
    $currentSuppliers = \App\Models\Supplier::where('country_id', $order->country_id)->get();
        $order = ConsignmentOrder::findOrFail($id);
        $warehouses = Warehouse::all();
        return view('admin.consignment_orders.edit', compact('order', 'warehouses','countries','currentSuppliers'));
    }

    // 4. Lưu cập nhật
public function update(Request $request, $id)
{
    $order = ConsignmentOrder::findOrFail($id);
    $employee = Auth::user();

   // Phân quyền
    if ($employee->vai_tro === 'nhan_vien' && $order->kho_hien_tai_id !== $employee->warehouse_id) {
        abort(403, 'Từ chối truy cập: Bạn không có quyền cập nhật đơn hàng không nằm trong kho của bạn!');
    }

    // 1. Validate dữ liệu đa quốc gia
    $request->validate([
        'chieu_van_chuyen'          => 'required|in:ve_vn,di_qt',
        'country_id'                => 'required|exists:countries,id',
        'supplier_id'               => 'required|exists:suppliers,id',
        'tru_so_nhan_hang_id'       => 'required|integer', 
        'kho_hien_tai_id'           => 'nullable|exists:warehouses,id',
        'trang_thai'                => 'required|string',
        'packages'                  => 'required|array|min:1',
        'packages.*.ma_van_don'     => 'required|string',
        'packages.*.ten_san_pham'   => 'required|string',
        'packages.*.so_kien_hang'   => 'required|integer|min:1',
        'packages.*.hang_van_chuyen'=> 'required|string',
        'packages.*.so_luong'       => 'required|integer|min:1',
        'packages.*.gia_tri_hang_hoa'=> 'required|numeric|min:0',
        'packages.*.loai_danh_muc'  => 'nullable|string',
    ]);

    try {
        DB::transaction(function () use ($request, $order) {
            
            $khoCuCuaDon = $order->getOriginal('kho_hien_tai_id');
            $khoMoiCuaDon = $request->kho_hien_tai_id ?? $order->kho_hien_tai_id;
            $tenKhoMoi = Warehouse::find($khoMoiCuaDon)->ten_kho ?? 'Kho không xác định';

            // ==========================================
            // 2. LOGIC TẠO KIỆN HÀNG & TRACKING GỐC
            // ==========================================
            if ($request->trang_thai == 'dang_xu_ly') {
                $daCoKienHang = Package::where('consignment_order_id', $order->id)->exists();
                
                if (!$daCoKienHang) {
                    $items = ConsignmentOrderItem::where('consignment_order_id', $order->id)->get();
                    
                    foreach ($items as $item) {
                        $newPkg = Package::create([
                            'ma_van_don'           => $item->ma_van_don, 
                            'ma_don_kien_hang'     => 'PKG' . time() . rand(100, 999),
                            'order_id'             => null,
                            'consignment_order_id' => $order->id,
                            'tinh_trang'           => 'cho_xu_ly',
                            'loai_hang'            => $item->loai_danh_muc,
                            'tru_so_id'            => $khoMoiCuaDon, // Gán ngay kho mới nhất
                            'tong_kg'              => null, 
                        ]);

                        // Tự động sinh Tracking gốc để khách hàng thấy kiện đã được nhập kho
                        PackageTracking::create([
                            'package_id'   => $newPkg->id,
                            'warehouse_id' => $khoMoiCuaDon,
                            'employee_id'  => Auth::id(),
                            'title'        => 'Khởi tạo kiện hàng',
                            'description'  => "Kiện hàng được duyệt và nhập vào: " . $tenKhoMoi,
                        ]);
                    }
                }
            }

            // ==========================================
            // 3. LOGIC TRACKING KHI THAY ĐỔI KHO BÃI
            // ==========================================
            if ($khoCuCuaDon != $khoMoiCuaDon) {
                // Lấy tất cả kiện hàng (nếu có)
                $packages = Package::where('consignment_order_id', $order->id)->get(); 

                foreach ($packages as $pkg) {
                    // Cần kiểm tra: Nếu kiện này vừa được tạo ở bước 2 thì bỏ qua không tạo Tracking "Luân chuyển" nữa để tránh trùng lặp.
                    if ($pkg->tru_so_id != $khoMoiCuaDon) {
                        
                        $pkg->update(['tru_so_id' => $khoMoiCuaDon]);

                        PackageTracking::create([
                            'package_id'   => $pkg->id,
                            'warehouse_id' => $khoMoiCuaDon,
                            'employee_id'  => Auth::id(),
                            'title'        => 'Luân chuyển theo Đơn hàng',
                            'description'  => "Kiện hàng được tự động cập nhật vị trí theo đơn cha tới: " . $tenKhoMoi,
                        ]);
                    }
                }
            }

            // ==========================================
            // 4. CẬP NHẬT THÔNG TIN ĐƠN HÀNG (BẢNG CHA)
            // ==========================================
            $tocDo = $request->packages[array_key_first($request->packages)]['yeu_cau_toc_do'] ?? $request->yeu_cau_toc_do ?? 'thuong';
            
            $order->update([
                'chieu_van_chuyen' => $request->chieu_van_chuyen,
                'country_id'       => $request->country_id,
                'supplier_id'      => $request->supplier_id,
                'kho_vn_id'        => $request->tru_so_nhan_hang_id,
                'kho_hien_tai_id'  => $khoMoiCuaDon,
                'so_kien'          => count($request->packages),
                'yeu_cau_toc_do'   => $tocDo,
                'trang_thai'       => $request->trang_thai,
                'dia_chi_tra_hang' => $request->dia_chi_tra_hang,
                'ngay_van_chuyen'  => $request->ngay_van_chuyen,
                'ngay_nhan_hang'   => $request->ngay_nhan_hang,
            ]);

            // ==========================================
            // 5. CẬP NHẬT CÁC SẢN PHẨM (ITEMS)
            // ==========================================
            $existingItemIds = $order->items->pluck('id')->toArray();
            $submittedItemIds = [];
            $hasDongGo = false;
            $hasKiemHang = false;

            $stt = 1;
            foreach ($request->packages as $index => $pkg) {
                
                $hinhAnhUrl = $pkg['hinh_anh_cu'] ?? null;
                if ($request->hasFile("packages.{$index}.hinh_anh_file")) {
                    $file = $request->file("packages.{$index}.hinh_anh_file");
                    $path = $file->store('uploads/consignments', 'public');
                    $hinhAnhUrl = '/storage/' . $path;
                }

                $dataItem = [
                    'stt'                  => $stt++,
                    'hinh_anh_url'         => $hinhAnhUrl,
                    'ma_van_don'           => $pkg['ma_van_don'],
                    'ten_san_pham'         => $pkg['ten_san_pham'],
                    'so_kien_hang'         => $pkg['so_kien_hang'],
                    'hang_van_chuyen'      => $pkg['hang_van_chuyen'],
                    'loai_danh_muc'        => $pkg['loai_danh_muc'] ?? null,
                    'so_luong'             => $pkg['so_luong'],
                    'gia_tri_hang_hoa'     => $pkg['gia_tri_hang_hoa'], 
                    'link_san_pham'        => $pkg['link_san_pham'] ?? null,
                    'ghi_chu'              => $pkg['ghi_chu'] ?? null,
                ];

                if (!empty($pkg['id'])) {
                    $orderItem = ConsignmentOrderItem::find($pkg['id']);
                    if ($orderItem && $orderItem->consignment_order_id == $order->id) {
                        $orderItem->update($dataItem);
                        $submittedItemIds[] = $orderItem->id;
                    }
                } else {
                    $dataItem['consignment_order_id'] = $order->id;
                    $newItem = ConsignmentOrderItem::create($dataItem);
                    $submittedItemIds[] = $newItem->id;
                }

                if (isset($pkg['dong_go'])) $hasDongGo = true;
                if (isset($pkg['kiem_hang'])) $hasKiemHang = true;
            }

            $itemsToDelete = array_diff($existingItemIds, $submittedItemIds);
            if (count($itemsToDelete) > 0) {
                ConsignmentOrderItem::whereIn('id', $itemsToDelete)->delete();
            }

            ConsignmentExtraRequirement::where('consignment_order_id', $order->id)->delete();
            if ($hasDongGo) ConsignmentExtraRequirement::create(['consignment_order_id' => $order->id, 'loai_yeu_cau' => 'dong_go']);
            if ($hasKiemHang) ConsignmentExtraRequirement::create(['consignment_order_id' => $order->id, 'loai_yeu_cau' => 'kiem_hang']);
        });

        return redirect()->route('admin.consignment_orders.show', $order->id)->with('success', 'Cập nhật đơn ký gửi thành công!');

    } catch (\Exception $e) {
        return back()->withErrors('Lỗi hệ thống: ' . $e->getMessage())->withInput();
    }
}

    // 5. Xoá đơn
    public function destroy($id)
    {
        $order = ConsignmentOrder::findOrFail($id);
        
        if ($order->trang_thai == 'hoan_thanh') {
            return back()->withErrors('Không thể xoá đơn ký gửi đã hoàn thành.');
        }

        $order->delete();
        return redirect()->route('admin.consignment_orders.index')->with('success', 'Đã xoá đơn ký gửi thành công!');
    }
}