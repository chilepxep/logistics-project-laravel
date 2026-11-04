<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\ConsignmentOrder;
use Illuminate\Support\Facades\Auth;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use App\Models\Warehouse;

class OrderListController extends Controller
{
    public function index() {
        $userId = Auth::id();

        //lấy danh sách đơn mua hộ của user
        $buyOrders = Order::where('user_id', $userId)->with('khoNhan')->orderBy('created_at', 'desc')->get();

       // Lấy danh sách đơn ký gửi của user (kèm theo thông tin kho)
       $consignmentOrders = ConsignmentOrder::where('user_id', $userId)
                                             ->orderBy('created_at', 'desc')
                                             ->get();

                return view('user.orders-list', compact('buyOrders', 'consignmentOrders'));                             
    }

    public function show($id)
    {
        // Lấy đơn hàng theo ID, đồng thời load luôn thông tin kho nhận và danh sách items
        $order = Order::with(['khoNhan', 'items'])->findOrFail($id);

        // Bảo mật: Kiểm tra xem đơn hàng này có đúng là của user đang đăng nhập không
        if ((int) $order->user_id !== (int) Auth::id()) {
            abort(403, 'Bạn không có quyền xem đơn hàng này!');
        }

        return view('user.order-detail', compact('order'));
    }

    // 1. Hàm mở giao diện Sửa
    public function edit($id)
    {
        $order = Order::with('items')->findOrFail($id);

        // Chỉ cho phép người tạo ra đơn mới được sửa
        if ((int) $order->user_id !== (int) Auth::id()) {
            abort(403, 'Bạn không có quyền sửa đơn hàng này!');
        }

        
        if ($order->trang_thai !== 'cho_xu_ly') {
            return redirect()->route('dashboard')->withErrors('Chỉ được sửa đơn hàng đang chờ báo giá.');
        }


        // Load danh sách Quốc gia 
    $countries = \App\Models\Country::all();
    //  danh sách Nhà cung cấp thuộc Quốc gia mà đơn hàng đang lưu
    $currentSuppliers = \App\Models\Supplier::where('country_id', $order->country_id)->get();
        // Lấy danh sách kho VN để render ra select box
        $warehouses = Warehouse::all();

        return view('user.order-edit', compact('order', 'countries','warehouses', 'currentSuppliers'));
    }

    // 2. Hàm xử lý Cập nhật dữ liệu
    public function update(Request $request, $id)
{
    $order = Order::findOrFail($id);

    if ((int) $order->user_id !== (int) Auth::id()) {
        abort(403);
    }

    // 1. Validate mở rộng (Thêm Quốc gia & NCC)
    $request->validate([
        'country_id'          => 'required|exists:countries,id',
        'supplier_id'         => 'required|exists:suppliers,id',
        'tru_so_nhan_hang_id' => 'required',
        'items'               => 'required|array|min:1',
        'items.*.ten_san_pham'=> 'required|string',
        'items.*.so_luong'    => 'required|integer|min:1',
        'items.*.don_gia'     => 'required|numeric|min:0',
    ], [
        'items.required' => 'Đơn hàng phải có ít nhất 1 sản phẩm.'
    ]);

    try {
        DB::transaction(function () use ($request, $order) {
            
            // 2. TÍNH TOÁN LẠI TỔNG TIỀN VNĐ
            $tongTienNgoaiTe = 0;
            $tongSoLuong = 0;

            foreach($request->items as $itemData) {
               $tongTienNgoaiTe += ($itemData['don_gia'] * $itemData['so_luong']);
               $tongSoLuong += $itemData['so_luong'];
            }

            // Lấy Tỉ giá của Quốc gia mới (hoặc giữ nguyên nếu không đổi)
            $country = \App\Models\Country::findOrFail($request->country_id);
            $tiGia = 3500; // Mặc định là Tệ (CNY)
            if ($country->tien_te == 'JPY') $tiGia = 170;
            if ($country->tien_te == 'AUD') $tiGia = 16500;
            if ($country->tien_te == 'EUR') $tiGia = 27000;

            // Tính các loại tiền (VNĐ)
            $tienHangVnd = $tongTienNgoaiTe * $tiGia;
            $phiMuaHoVnd = $tienHangVnd * 0.01; // Phí mua hộ 1%
            
            // Xử lý Phí dịch vụ (Dựa vào Extra Requirements cũ đang có trong DB)
            $phiDichVuVnd = 0;
            $extraReqs = $order->extraRequirements->pluck('loai_yeu_cau')->toArray();
            if (in_array('kiem_hang', $extraReqs)) {
                $phiDichVuVnd += ($tongSoLuong * 1000); 
            }
            if (in_array('dong_go', $extraReqs)) {
                $phiDichVuVnd += ($tongSoLuong * 5000); 
            }

            $tongTienThanhToan = $tienHangVnd + $phiMuaHoVnd + $phiDichVuVnd;

            // 3. Cập nhật thông tin chung của Đơn hàng (Cập nhật cả Tiền và Quốc gia)
            $order->update([
                'country_id'          => $request->country_id,
                'supplier_id'         => $request->supplier_id,
                'tru_so_nhan_hang_id' => $request->tru_so_nhan_hang_id,
                'yeu_cau_toc_do'      => $request->yeu_cau_toc_do ?? 'thuong',
                'tong_tien'           => $tongTienThanhToan, // Lưu lại tổng tiền VNĐ mới
            ]);

           // 4. Xử lý danh sách Items và dọn dẹp file
            $existingItemIds = $order->items->pluck('id')->toArray();
            $submittedItemIds = []; 

            foreach ($request->items as $index => $itemData) {
                
                $hinhAnhUrl = $itemData['hinh_anh_cu'] ?? null;
                
                // CÓ UPLOAD ẢNH MỚI
                if ($request->hasFile("items.{$index}.hinh_anh_file")) {
                    $file = $request->file("items.{$index}.hinh_anh_file");
                    $path = $file->store('uploads/orders', 'public');
                    $hinhAnhUrl = '/storage/' . $path;

                    // Xóa ảnh cũ trên server (nếu có) khi người dùng thay ảnh mới
                    if (!empty($itemData['hinh_anh_cu'])) {
                        $oldRelativePath = preg_replace('#^.*/storage/#', '', $itemData['hinh_anh_cu']);
                        if (\Illuminate\Support\Facades\Storage::disk('public')->exists($oldRelativePath)) {
                            \Illuminate\Support\Facades\Storage::disk('public')->delete($oldRelativePath);
                        }
                    }
                }

                if (!empty($itemData['id'])) {
                    // Cập nhật Item cũ
                    $orderItem = OrderItem::find($itemData['id']);
                    if ($orderItem && $orderItem->order_id == $order->id) {
                        $orderItem->update([
                            'link_san_pham'      => $itemData['link_san_pham'] ?? null,
                            'ten_san_pham'       => $itemData['ten_san_pham'],
                            'mau_sac_kich_thuoc' => $itemData['thuoc_tinh'] ?? null,
                            'so_luong'           => $itemData['so_luong'],
                            'don_gia'            => $itemData['don_gia'], 
                            'ghi_chu_khac'       => $itemData['ghi_chu'] ?? null,
                            'hinh_anh_url'       => $hinhAnhUrl,
                        ]);
                        $submittedItemIds[] = $orderItem->id;
                    }
                } else {
                    // Thêm mới Item
                    $newItem = OrderItem::create([
                        'order_id'           => $order->id,
                        'stt'                => $order->items->count() + count($submittedItemIds) + 1,
                        'link_san_pham'      => $itemData['link_san_pham'] ?? null,
                        'ten_san_pham'       => $itemData['ten_san_pham'],
                        'mau_sac_kich_thuoc' => $itemData['thuoc_tinh'] ?? null,
                        'so_luong'           => $itemData['so_luong'],
                        'don_gia'            => $itemData['don_gia'], 
                        'ghi_chu_khac'       => $itemData['ghi_chu'] ?? null,
                        'hinh_anh_url'       => $hinhAnhUrl,
                    ]);
                    $submittedItemIds[] = $newItem->id;
                }
            }

            // Xóa Item thừa và Dọn rác file vật lý
            $itemsToDelete = array_diff($existingItemIds, $submittedItemIds);
            
            if (count($itemsToDelete) > 0) {
                // Lấy các item sắp bị xóa để quét đường dẫn ảnh
                $deletedItems = OrderItem::whereIn('id', $itemsToDelete)->get();
                
                foreach ($deletedItems as $item) {
                    if (!empty($item->hinh_anh_url)) {
                        $relativePath = preg_replace('#^.*/storage/#', '', $item->hinh_anh_url);
                        if (\Illuminate\Support\Facades\Storage::disk('public')->exists($relativePath)) {
                            \Illuminate\Support\Facades\Storage::disk('public')->delete($relativePath);
                        }
                    }
                }
                
                // Xóa Database
                OrderItem::whereIn('id', $itemsToDelete)->delete();
            }
        });

        return redirect()->route('order.show', $order->id)->with('success', 'Cập nhật đơn hàng thành công!');

    } catch (\Exception $e) {
        return back()->withErrors('Lỗi hệ thống: ' . $e->getMessage())->withInput();
    }
}

// 3. Hàm xử lý Xóa đơn hàng (Dành cho Người Dùng)
    public function destroy($id)
    {
        $order = Order::findOrFail($id);

        // Bảo mật: Chỉ cho phép chủ nhân của đơn hàng mới được xóa
        if ((int) $order->user_id !== (int) Auth::id()) {
            abort(403, 'Bạn không có quyền xóa đơn hàng này!');
        }

        // Quy tắc: Chỉ cho phép xóa khi đơn hàng đang 'chờ xử lý'
        if ($order->trang_thai !== 'cho_xu_ly') {
            return back()->withErrors('Bạn chỉ có thể xóa đơn hàng đang ở trạng thái Chờ xử lý.');
        }

        try {
            DB::transaction(function () use ($order, $id) {
                // Bước 1: Xóa các khiếu nại liên quan
                \App\Models\Complaint::where('order_id', $id)->delete();

                // Bước 2: TÌM VÀ XÓA CÁC SẢN PHẨM CON CÙNG FILE ẢNH VẬT LÝ
                $orderItems = \App\Models\OrderItem::where('order_id', $id)->get();
                
                foreach ($orderItems as $item) {
                    // Kiểm tra xem sản phẩm có ảnh không
                    if (!empty($item->hinh_anh_url) && str_starts_with($item->hinh_anh_url, '/storage/')) {
                        // Cắt bỏ '/storage/' để lấy đường dẫn tương đối
                        $relativePath = str_replace('/storage/', '', $item->hinh_anh_url);

                        // Xóa file vật lý khỏi server nếu file đó thực sự tồn tại
                        if (\Illuminate\Support\Facades\Storage::disk('public')->exists($relativePath)) {
                            \Illuminate\Support\Facades\Storage::disk('public')->delete($relativePath);
                        } 
                    }
                    // Xóa dòng dữ liệu trong DB
                    $item->delete();
                }

                // Bước 3: Tìm và xóa các Kiện hàng (Packages) + Lịch sử Tracking
                $packages = \App\Models\Package::where('order_id', $id)->get();
                foreach ($packages as $pkg) {
                    \App\Models\PackageTracking::where('package_id', $pkg->id)->delete();
                    $pkg->delete();
                }

                // Bước 4: Cuối cùng, xóa đơn hàng cha
                $order->delete();
            });

            return redirect()->route('list.order')->with('success', 'Đã xóa đơn mua hộ và dọn sạch dữ liệu liên quan thành công!');

        } catch (\Exception $e) {
            return back()->withErrors('Lỗi hệ thống khi xóa: ' . $e->getMessage());
        }
    }
}