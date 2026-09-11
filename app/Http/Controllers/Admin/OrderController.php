<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Warehouse; // Đảm bảo bạn đã có model này hoặc đổi tên cho khớp

class OrderController extends Controller
{
    // Lấy danh sách đơn hàng (Đã làm ở bước trước)
    public function index(Request $request)
    {
        $query = Order::query()->with('user'); // Load thêm thông tin khách hàng

        if ($request->filled('trang_thai')) {
            $query->where('trang_thai', $request->trang_thai);
        }

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

    // 1. Validate 
    $request->validate([
        'country_id'          => 'required|exists:countries,id',
        'supplier_id'         => 'required|exists:suppliers,id',
        'tru_so_nhan_hang_id' => 'required',
        'trang_thai'          => 'required',
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
            
            // 2. Cập nhật thông tin chung của Đơn hàng 
            $order->update([
                'country_id'          => $request->country_id,
                'supplier_id'         => $request->supplier_id,
                'tru_so_nhan_hang_id' => $request->tru_so_nhan_hang_id,
                'yeu_cau_toc_do'      => $request->yeu_cau_toc_do ?? 'thuong',
                'trang_thai'          => $request->trang_thai,
                'tong_tien'           => $request->tong_tien ?? $order->tong_tien,
            ]);

            // 3. Logic tự động tạo kiện hàng
            $trangThaiMoi = $request->trang_thai; 
            if ($trangThaiMoi == 'dang_xu_ly') {
                $daCoKienHang = \App\Models\Package::where('order_id', $order->id)->exists();
                
                if (!$daCoKienHang) {
                    \App\Models\Package::create([
                        'ma_van_don'             => 'CHUA_CAP_NHAT', 
                        'ma_don_kien_hang'       => 'PKG' . time() . rand(100, 999), 
                        'order_id'               => $order->id,
                        'consignment_order_id'   => null,
                        'tinh_trang'             => 'da_dat_hang', 
                        'loai_hang'              => 'Hàng mua hộ',
                        'tru_so_id'              => $request->tru_so_nhan_hang_id, // Lấy ID mới nhất từ request
                        'phi_van_chuyen_noi_dia' => 0,
                        'thanh_tien'             => 0
                    ]);
                }
            }

            // 4. Xử lý danh sách Sản phẩm (Items)
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
                    // CẬP NHẬT sản phẩm cũ
                    $orderItem = OrderItem::find($itemData['id']);
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
                    // THÊM MỚI sản phẩm
                    $newItem = OrderItem::create([
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

            // 5. XÓA các Sản phẩm không còn tồn tại trên form
            $itemsToDelete = array_diff($existingItemIds, $submittedItemIds);
            if (count($itemsToDelete) > 0) {
                OrderItem::whereIn('id', $itemsToDelete)->delete();
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
        $order = Order::findOrFail($id);

        // Tùy chọn: Bạn có thể chặn không cho Admin xoá đơn đã Hoàn thành để giữ lịch sử kế toán
        if ($order->trang_thai == 'hoan_thanh') {
            return back()->withErrors('Không thể xoá đơn hàng đã hoàn thành để đảm bảo dữ liệu kế toán.');
        }

        try {
            DB::transaction(function () use ($order) {
                // Bước 1: Xóa toàn bộ sản phẩm (items) thuộc về đơn hàng này
                OrderItem::where('order_id', $order->id)->delete();

                // Bước 2: Xóa đơn hàng cha
                $order->delete();
            });

            return redirect()->route('admin.orders.index')->with('success', 'Đã xóa đơn hàng thành công!');

        } catch (\Exception $e) {
            return back()->withErrors('Lỗi hệ thống khi xóa: ' . $e->getMessage());
        }
    }
}