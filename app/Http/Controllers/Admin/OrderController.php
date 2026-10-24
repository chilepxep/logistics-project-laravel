<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Warehouse;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // Lấy danh sách đơn hàng
    public function index(Request $request)
    {
        // 1. Khởi tạo query và load thông tin khách hàng
        $query = Order::query()->with(['user', 'supplier', 'warehouse', 'khoHienTai']);

        // 2. Lấy thông tin nhân viên đang đăng nhập
        $employee = Auth::user();

        // 3. Phân quyền lọc dữ liệu theo Trụ sở 
       if ($employee->vai_tro === 'nhan_vien') {
    $query->where('kho_hien_tai_id', $employee->warehouse_id);
            
        } elseif ($employee->vai_tro !== 'admin') {
            // Chặn các tài khoản không hợp lệ
            $query->where('id', 0); 
        }

        // 4. Lọc theo trạng thái từ request
        if ($request->filled('trang_thai')) {
            $query->where('trang_thai', $request->trang_thai);
        }

        // 5. Thực thi query, sắp xếp và phân trang
        $orders = $query->orderByDesc('created_at')->paginate(15);
        
        return view('admin.orders.index', compact('orders'));
    }

    // 1. Giao diện Chi tiết Đơn hàng
    public function show($id)
    {
        // Admin xem chi tiết load đầy đủ Khách hàng, Kho nhận, và Sản phẩm
        $order = Order::with(['user', 'khoNhan', 'items'])->findOrFail($id);

        return view('admin.orders.show', compact('order'));
    }

    // 2. Giao diện Sửa Đơn hàng
    public function edit($id)
    {
        $order = Order::with('items')->findOrFail($id);
        
              // Load danh sách Quốc gia 
        $countries = \App\Models\Country::all();
        //  danh sách Nhà cung cấp thuộc Quốc gia mà đơn hàng đang lưu
        $currentSuppliers = \App\Models\Supplier::where('country_id', $order->country_id)->get();
        // Admin lấy danh sách kho VN để sửa nếu khách chọn sai
        $warehouses = Warehouse::all(); 

        return view('admin.orders.edit', compact('order', 'warehouses','countries','currentSuppliers'));
    }

    // 3. Xử lý Cập nhật dữ liệu
public function update(Request $request, $id)
{
    $order = Order::findOrFail($id);
    $employee = Auth::user();

    

    if ($employee->vai_tro === 'nhan_vien' && $order->kho_hien_tai_id !== $employee->warehouse_id) {
        abort(403, 'Từ chối truy cập: Bạn không có quyền cập nhật đơn hàng không nằm trong kho của bạn!');
    }

    // 1. Validate 
    $request->validate([
        'country_id'          => 'required|exists:countries,id',
        'supplier_id'         => 'required|exists:suppliers,id',
        'tru_so_nhan_hang_id' => 'required',
        'kho_hien_tai_id'     => 'nullable',
        //'trang_thai'          => 'required',
        'items'               => 'required|array|min:1',
        'items.*.ten_san_pham'=> 'required|string',
        'items.*.don_gia'     => 'required|numeric|min:0',
        'items.*.so_luong'    => 'required|integer|min:1',
    ], [
        'items.required'                => 'Đơn hàng phải có ít nhất 1 sản phẩm.',
        'items.*.ten_san_pham.required' => 'Bạn chưa nhập tên sản phẩm cho một số món hàng.',
        'country_id.required'           => 'Vui lòng chọn Quốc gia.',
        'supplier_id.required'          => 'Vui lòng chọn Kho xuất phát.',
    ]);

    try {
        DB::transaction(function () use ($request, $order) {
            
            
            $khoCuCuaDon = $order->kho_hien_tai_id; 
            $khoMoiCuaDon = $request->kho_hien_tai_id ?? $order->kho_hien_tai_id;
            $tenKhoMoi = \App\Models\Warehouse::find($khoMoiCuaDon)->ten_kho ?? 'Kho không xác định';

            // 2. Cập nhật thông tin chung của Đơn hàng 
            $order->update([
                'country_id'          => $request->country_id,
                'supplier_id'         => $request->supplier_id,
                'tru_so_nhan_hang_id' => $request->tru_so_nhan_hang_id,
                'kho_hien_tai_id'     => $khoMoiCuaDon, 
                'yeu_cau_toc_do'      => $request->yeu_cau_toc_do ?? 'thuong',
               // 'trang_thai'          => $request->trang_thai,
                'tong_tien'           => $request->tong_tien ?? $order->tong_tien,
            ]);


           
            if ($khoCuCuaDon != $khoMoiCuaDon) {
                
                $packages = \App\Models\Package::where('order_id', $order->id)->get(); 

                foreach ($packages as $pkg) {
                    
                    // Kiểm tra chống trùng lặp: Chỉ tạo tracking luân chuyển nếu kiện hàng thực sự bị đổi kho
                    if ($pkg->tru_so_id != $khoMoiCuaDon) {
                        
                        // 4.1 Cập nhật vị trí kiện hàng
                        $pkg->update(['tru_so_id' => $khoMoiCuaDon]);

                        // 4.2 Ghi lịch sử hành trình
                        \App\Models\PackageTracking::create([
                            'package_id'   => $pkg->id,
                            'warehouse_id' => $khoMoiCuaDon,
                            'employee_id'  => Auth::id(),
                            'title'        => 'Luân chuyển theo Đơn hàng',
                            'description'  => "Kiện hàng được tự động cập nhật vị trí theo đơn cha tới: " . $tenKhoMoi,
                        ]);
                    }
                }
            }


            // 5. XỬ LÝ DANH SÁCH SẢN PHẨM

            $existingItemIds = $order->items->pluck('id')->toArray();
            $submittedItemIds = []; 

            foreach ($request->items as $index => $itemData) {
                
                // Logic xử lý ảnh
                $hinhAnhUrl = $itemData['hinh_anh_cu'] ?? null;
                if ($request->hasFile("items.{$index}.hinh_anh_file")) {
                    $file = $request->file("items.{$index}.hinh_anh_file");
                    $path = $file->store('uploads/orders', 'public');
                    $hinhAnhUrl = '/storage/' . $path;
                }

                if (!empty($itemData['id'])) {
                    $orderItem = \App\Models\OrderItem::find($itemData['id']);
                    if ($orderItem && $orderItem->order_id == $order->id) {
                        $orderItem->update([
                            'link_san_pham'      => $itemData['link_san_pham'] ?? null,
                            'ten_san_pham'       => $itemData['ten_san_pham'],
                            'mau_sac_kich_thuoc' => $itemData['mau_sac_kich_thuoc'] ?? null,
                            'so_luong'           => $itemData['so_luong'],
                            'don_gia'            => $itemData['don_gia'] ?? 0,
                            'ghi_chu_khac'       => $itemData['ghi_chu_khac'] ?? null,
                            'hinh_anh_url'       => $hinhAnhUrl,
                        ]);
                        $submittedItemIds[] = $orderItem->id;
                    }
                } else {
                    $newItem = \App\Models\OrderItem::create([
                        'order_id'           => $order->id,
                        'stt'                => $index + 1, 
                        'link_san_pham'      => $itemData['link_san_pham'] ?? null,
                        'ten_san_pham'       => $itemData['ten_san_pham'],
                        'mau_sac_kich_thuoc' => $itemData['mau_sac_kich_thuoc'] ?? null,
                        'so_luong'           => $itemData['so_luong'],
                        'don_gia'            => $itemData['don_gia'] ?? 0,
                        'ghi_chu_khac'       => $itemData['ghi_chu_khac'] ?? null,
                        'hinh_anh_url'       => $hinhAnhUrl,
                    ]);
                    $submittedItemIds[] = $newItem->id;
                }
            }

            // Xóa các Item không tồn tại trên form
            $itemsToDelete = array_diff($existingItemIds, $submittedItemIds);
            if (count($itemsToDelete) > 0) {
                \App\Models\OrderItem::whereIn('id', $itemsToDelete)->delete();
            }
        });

        return redirect()->route('admin.orders.show', $order->id)->with('success', 'Cập nhật đơn mua hộ thành công!');

    } catch (\Exception $e) {
        return back()->withErrors('Lỗi hệ thống: ' . $e->getMessage())->withInput();
    }
}

    // 4. Hàm xử lý Xóa đơn hàng
    public function destroy($id)
    {
        try {
            DB::transaction(function () use ($id) {
                $order = \App\Models\Order::findOrFail($id);

                // 1. Xóa các khiếu nại liên quan
                \App\Models\Complaint::where('order_id', $id)->delete();

                // 2. TÌM VÀ XÓA CÁC SẢN PHẨM CON CÙNG FILE ẢNH VẬT LÝ
                $orderItems = \App\Models\OrderItem::where('order_id', $id)->get();
                
                foreach ($orderItems as $item) {
                    // Kiểm tra xem sản phẩm có ảnh không
                    if (!empty($item->hinh_anh_url) && str_starts_with($item->hinh_anh_url, '/storage/')) {
                        // Cắt bỏ '/storage/' để lấy đường dẫn tương đối (VD: 'uploads/orders/ten-file.png')
                        $relativePath = str_replace('/storage/', '', $item->hinh_anh_url);

                        // Xóa file vật lý khỏi server nếu file đó thực sự tồn tại
                        if (\Illuminate\Support\Facades\Storage::disk('public')->exists($relativePath)) {
                            \Illuminate\Support\Facades\Storage::disk('public')->delete($relativePath);
                        }
                    }
                    // Xóa dòng dữ liệu trong DB
                    $item->delete();
                }

                // 3. Tìm và xóa các Kiện hàng (Packages) + Lịch sử Tracking
                $packages = \App\Models\Package::where('order_id', $id)->get();
                foreach ($packages as $pkg) {
                    \App\Models\PackageTracking::where('package_id', $pkg->id)->delete();
                    $pkg->delete();
                }

                // 4. Cuối cùng, xóa đơn hàng gốc
                $order->delete();
            });

            return redirect()->route('admin.orders.index')->with('success', 'Đã xóa vĩnh viễn đơn mua hộ và dọn sạch file ảnh liên quan!');

        } catch (\Exception $e) {
            return back()->withErrors('Lỗi khi xóa dữ liệu: ' . $e->getMessage());
        }
    }

    public function confirm($id)
    {
        $order = \App\Models\Order::findOrFail($id);

        // Chống thao tác trùng lặp
        if ($order->trang_thai !== 'cho_xu_ly') {
            return back()->withErrors('Đơn hàng này đã được xác nhận trước đó!');
        }

        try {
            $newPkgId = null;

            DB::transaction(function () use ($order, &$newPkgId) {
                
                // 1. Đổi trạng thái Order thành Xác nhận đặt hàng
                $order->update(['trang_thai' => 'xac_nhan_dat_hang']);

                // 2. Tự động sinh Kiện hàng
                $tenKhoMoi = \App\Models\Warehouse::find($order->kho_hien_tai_id)->ten_kho ?? 'Kho không xác định';
                
                $newPkg = \App\Models\Package::create([
                    'ma_van_don'             => 'CHUA_CAP_NHAT', 
                    'ma_don_kien_hang'       => 'PKG' . time() . rand(100, 999), 
                    'order_id'               => $order->id,
                    'tinh_trang'             => 'cho_xu_ly', 
                    'loai_hang'              => 'Hàng mua hộ',
                    'tru_so_id'              => $order->kho_hien_tai_id, 
                    'phi_van_chuyen_noi_dia' => 0,
                    'thanh_tien'             => 0
                ]);

                $newPkgId = $newPkg->id;

                // 3. Ghi Tracking lịch sử cho kiện hàng vừa tạo
                \App\Models\PackageTracking::create([
                    'package_id'   => $newPkg->id,
                    'warehouse_id' => $order->kho_hien_tai_id,
                    'employee_id'  => Auth::id(),
                    'title'        => 'Khởi tạo kiện hàng',
                    'description'  => "Kiện hàng được khởi tạo thành công tại: " . $tenKhoMoi,
                ]);
            });

            // Chuyển thẳng nhân viên sang trang Edit của Kiện hàng vừa tạo
            return redirect()->route('admin.packages.edit', $newPkgId)
                            ->with('success', 'Đã xác nhận đơn hàng! Mời bạn cập nhật lộ trình Kiện hàng.');

        } catch (\Exception $e) {
            return back()->withErrors('Lỗi hệ thống khi xác nhận đơn: ' . $e->getMessage());
        }
    }

    public function cancel($id)
    {
        $order = \App\Models\Order::findOrFail($id);

        if (!in_array($order->trang_thai, ['cho_xu_ly', 'xac_nhan_dat_hang'])) {
            return back()->withErrors('Không thể hủy! Đơn hàng này đã bắt đầu được luân chuyển.');
        }

        try {
            DB::transaction(function () use ($order) {
                
                // 1. Cập nhật trạng thái Đơn hàng thành Đã hủy
                $order->update(['trang_thai' => 'da_huy']);

                // 2. Thu hồi các Kiện hàng vật lý đã lỡ tạo để không bị rác trong kho
                $packages = \App\Models\Package::where('order_id', $order->id)->get();
                foreach ($packages as $pkg) {
                    \App\Models\PackageTracking::where('package_id', $pkg->id)->delete();
                    $pkg->delete();
                }
            });

            return back()->with('success', 'Đã hủy đơn hàng thành công! Các kiện hàng liên quan đã được thu hồi.');

        } catch (\Exception $e) {
            return back()->withErrors('Lỗi khi hủy đơn: ' . $e->getMessage());
        }
    }
}