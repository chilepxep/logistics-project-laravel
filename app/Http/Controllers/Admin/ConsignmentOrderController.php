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
        // 1. Lấy thông tin đơn hàng và chi tiết (gọi 1 lần)
        $order = ConsignmentOrder::with(['items', 'extraRequirements'])->findOrFail($id);
        
        $countries = \App\Models\Country::all();
        
        // 2. Lấy danh sách Kho Quốc Tế (Bỏ kho VN)
        $internationalWarehouses = \App\Models\Warehouse::where('loai_kho', '!=', 'VN')->get();
        
        // 3. Lấy danh sách Kho Việt Nam (Chỉ lấy kho VN)
        $warehouses = \App\Models\Warehouse::where('loai_kho', 'VN')->get();
        
        return view('admin.consignment_orders.edit', compact('order', 'warehouses', 'countries', 'internationalWarehouses'));
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

            // 1. Validate dữ liệu 
            $request->validate([
                'chieu_van_chuyen'      => 'required|in:ve_vn,di_qt',
                'country_id'            => 'required|exists:countries,id',
                'supplier_id'           => 'required|exists:suppliers,id',
                'tru_so_nhan_hang_id'   => 'required|integer', 
                'kho_hien_tai_id'       => 'nullable|exists:warehouses,id',
                'trang_thai_thanh_toan' => 'required|in:chua_thanh_toan,da_thanh_toan',
                'packages'              => 'required|array|min:1',
                'packages.*.ma_van_don' => 'required|string',
                'packages.*.ten_san_pham'=> 'required|string',
                'packages.*.so_kien_hang'=> 'required|integer|min:1',
                'packages.*.hang_van_chuyen'=> 'required|string',
                'packages.*.so_luong'   => 'required|integer|min:1',
                'packages.*.gia_tri_hang_hoa'=> 'required|numeric|min:0',
            ]);

            try {
                DB::transaction(function () use ($request, $order) {
                    
                    $khoCuCuaDon = $order->getOriginal('kho_hien_tai_id');
                    $khoMoiCuaDon = $request->kho_hien_tai_id ?? $order->kho_hien_tai_id;
                    $tenKhoMoi = Warehouse::find($khoMoiCuaDon)->ten_kho ?? 'Kho không xác định';

                    // 2. Logic cập nhật Ngày thanh toán
                    $ngayThanhToan = $order->ngay_thanh_toan; 
                    if ($request->trang_thai_thanh_toan == 'da_thanh_toan' && $order->trang_thai_thanh_toan != 'da_thanh_toan') {
                        $ngayThanhToan = now(); 
                    } elseif ($request->trang_thai_thanh_toan == 'chua_thanh_toan') {
                        $ngayThanhToan = null; 
                    }

                    // 3. CẬP NHẬT THÔNG TIN ĐƠN HÀNG 
                    $tocDo = $request->packages[array_key_first($request->packages)]['yeu_cau_toc_do'] ?? $request->yeu_cau_toc_do ?? 'thuong';
                    
                    $order->update([
                        'chieu_van_chuyen' => $request->chieu_van_chuyen,
                        'country_id'       => $request->country_id,
                        'supplier_id'      => $request->supplier_id,
                        'kho_vn_id'        => $request->tru_so_nhan_hang_id,
                        'kho_hien_tai_id'  => $khoMoiCuaDon,
                        'so_kien'          => count($request->packages),
                        'yeu_cau_toc_do'   => $tocDo,
                        'trang_thai_thanh_toan' => $request->trang_thai_thanh_toan,
                        'ngay_thanh_toan'       => $ngayThanhToan,
                        'dia_chi_tra_hang' => $request->dia_chi_tra_hang,
                        'ngay_van_chuyen'  => $request->ngay_van_chuyen,
                        'ngay_nhan_hang'   => $request->ngay_nhan_hang, 
                    ]);

                    // 4. CẬP NHẬT CÁC SẢN PHẨM 
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
        try {
            DB::transaction(function () use ($id) {
                $order = \App\Models\ConsignmentOrder::findOrFail($id);

                // 1. TÌM VÀ XÓA SẢN PHẨM KÝ GỬI CÙNG FILE ẢNH VẬT LÝ
                $consignmentItems = \App\Models\ConsignmentOrderItem::where('consignment_order_id', $id)->get();
                
                foreach ($consignmentItems as $item) {
                    // Kiểm tra và xóa file ảnh trong thư mục uploads/consignments
                    if (!empty($item->hinh_anh_url) && str_starts_with($item->hinh_anh_url, '/storage/')) {
                        $relativePath = str_replace('/storage/', '', $item->hinh_anh_url);

                        if (\Illuminate\Support\Facades\Storage::disk('public')->exists($relativePath)) {
                            \Illuminate\Support\Facades\Storage::disk('public')->delete($relativePath);
                        }
                    }
                    // Xóa dòng dữ liệu sau khi đã dọn dẹp file
                    $item->delete();
                }

                // 2. Xóa các dịch vụ gia tăng 
                \App\Models\ConsignmentExtraRequirement::where('consignment_order_id', $id)->delete();

                // 3. Xóa các Kiện hàng vật lý (Packages) + Lịch sử Tracking
                $packages = \App\Models\Package::where('consignment_order_id', $id)->get();
                foreach ($packages as $pkg) {
                    \App\Models\PackageTracking::where('package_id', $pkg->id)->delete();
                    $pkg->delete();
                }

                // 4. Xóa đơn hàng gốc
                $order->delete();
            });

            return redirect()->route('admin.consignment_orders.index')->with('success', 'Đã xóa vĩnh viễn đơn ký gửi và dọn sạch file ảnh!');

        } catch (\Exception $e) {
            return back()->withErrors('Lỗi khi xóa dữ liệu: ' . $e->getMessage());
        }
    }

    public function confirm($id)
    {
        $order = \App\Models\ConsignmentOrder::findOrFail($id);

        if ($order->trang_thai !== 'cho_xu_ly') {
            return back()->withErrors('Đơn ký gửi này đã được xử lý trước đó!');
        }

        try {
            $newPkgId = null;

            DB::transaction(function () use ($order, &$newPkgId) {
                
                // 1. Chuyển trạng thái đơn Ký gửi
                $order->update(['trang_thai' => 'xac_nhan_dat_hang']);

                // 2. Tự động sinh Kiện hàng 
                $tenKhoMoi = \App\Models\Warehouse::find($order->kho_hien_tai_id)->ten_kho ?? 'Kho không xác định';
                
                $newPkg = \App\Models\Package::create([
                    'ma_van_don'             => 'CHUA_CAP_NHAT', 
                    'ma_don_kien_hang'       => 'PKG_KG' . time() . rand(100, 999), 
                    'order_id'               => null, 
                    'consignment_order_id'   => $order->id, 
                    'tinh_trang'             => 'cho_xu_ly', 
                    'loai_hang'              => 'Hàng ký gửi',
                    'tru_so_id'              => $order->kho_hien_tai_id, 
                    'phi_van_chuyen_noi_dia' => 0,
                    'thanh_tien'             => 0
                ]);

                $newPkgId = $newPkg->id;

                // 3. Ghi Tracking lịch sử
                \App\Models\PackageTracking::create([
                    'package_id'   => $newPkg->id,
                    'warehouse_id' => $order->kho_hien_tai_id,
                    'employee_id'  => Auth::id(),
                    'title'        => 'Khởi tạo kiện hàng ký gửi',
                    'description'  => "Kiện hàng ký gửi được nhận và khởi tạo tại: " . $tenKhoMoi,
                ]);
            });

            // Chuyển hướng thẳng sang trang Edit của Kiện hàng vừa tạo
            return redirect()->route('admin.packages.edit', $newPkgId)
                             ->with('success', 'Đã xác nhận đơn ký gửi! Mời bạn tiếp tục cập nhật lộ trình.');

        } catch (\Exception $e) {
            return back()->withErrors('Lỗi hệ thống khi xác nhận đơn: ' . $e->getMessage());
        }
    }
}