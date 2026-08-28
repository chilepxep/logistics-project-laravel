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
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Bạn không có quyền xem đơn hàng này!');
        }

        return view('user.order-detail', compact('order'));
    }

    // 1. Hàm mở giao diện Sửa
    public function edit($id)
    {
        $order = Order::with('items')->findOrFail($id);

        // Chỉ cho phép người tạo ra đơn mới được sửa
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Bạn không có quyền sửa đơn hàng này!');
        }

        // Tùy chọn: Thường chỉ cho phép sửa khi đơn ở trạng thái 'Chờ báo giá'
        if ($order->trang_thai !== 'cho_bao_gia') {
            return redirect()->route('dashboard')->withErrors('Chỉ được sửa đơn hàng đang chờ báo giá.');
        }

        // Lấy danh sách kho VN để render ra select box
        $warehouses = Warehouse::all(); // (Hoặc lấy kho VN: where('loai_kho', 'VN')->get())

        return view('user.order-edit', compact('order', 'warehouses'));
    }

    // 2. Hàm xử lý Cập nhật dữ liệu
    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        // Validate cơ bản
        $request->validate([
            'tru_so_nhan_hang_id' => 'required',
            'items'               => 'required|array|min:1',
        ], [
            'items.required' => 'Đơn hàng phải có ít nhất 1 sản phẩm.'
        ]);

        try {
            DB::transaction(function () use ($request, $order) {
                // 1. Cập nhật thông tin chung của Đơn hàng
                $order->update([
                    'tru_so_nhan_hang_id' => $request->tru_so_nhan_hang_id,
                    'yeu_cau_toc_do'      => $request->yeu_cau_toc_do ?? 'thuong',
                ]);

                // 2. Xử lý danh sách Items
                // Lấy mảng ID của các item HIỆN TẠI trong database
                $existingItemIds = $order->items->pluck('id')->toArray();
                $submittedItemIds = []; // Mảng chứa ID của các item được submit lên từ form

                foreach ($request->items as $index => $itemData) {
                    
                    // Logic xử lý ảnh: Nếu có upload file mới thì lưu file, không thì giữ link cũ
                    $hinhAnhUrl = $itemData['hinh_anh_cu'] ?? null;
                    if ($request->hasFile("items.{$index}.hinh_anh_file")) {
                        $file = $request->file("items.{$index}.hinh_anh_file");
                        $path = $file->store('uploads/orders', 'public');
                        $hinhAnhUrl = '/storage/' . $path;
                    }

                    if (!empty($itemData['id'])) {
                        // Trường hợp 2.1: Item đã tồn tại -> CẬP NHẬT
                        $orderItem = OrderItem::find($itemData['id']);
                        if ($orderItem && $orderItem->order_id == $order->id) {
                            $orderItem->update([
                                'link_san_pham' => $itemData['link_san_pham'] ?? null,
                                'ten_san_pham'  => $itemData['ten_san_pham'],
                                'thuoc_tinh'    => $itemData['thuoc_tinh'] ?? null,
                                'so_luong'      => $itemData['so_luong'],
                                'don_gia_te'    => $itemData['don_gia_te'] ?? 0,
                                'ghi_chu'       => $itemData['ghi_chu'] ?? null,
                                'hinh_anh_url'  => $hinhAnhUrl,
                            ]);
                            $submittedItemIds[] = $orderItem->id;
                        }
                    } else {
                        // Trường hợp 2.2: Item không có ID -> THÊM MỚI (Do bấm nút Thêm dòng)
                        $newItem = OrderItem::create([
                            'order_id'      => $order->id,
                            'link_san_pham' => $itemData['link_san_pham'] ?? null,
                            'ten_san_pham'  => $itemData['ten_san_pham'],
                            'thuoc_tinh'    => $itemData['thuoc_tinh'] ?? null,
                            'so_luong'      => $itemData['so_luong'],
                            'don_gia_te'    => $itemData['don_gia_te'] ?? 0,
                            'ghi_chu'       => $itemData['ghi_chu'] ?? null,
                            'hinh_anh_url'  => $hinhAnhUrl,
                        ]);
                        $submittedItemIds[] = $newItem->id;
                    }
                }

                // Trường hợp 2.3: XÓA các Item không còn trong form
                // Lọc ra các ID có trong DB nhưng không được submit lên (tức là người dùng đã bấm Xóa dòng)
                $itemsToDelete = array_diff($existingItemIds, $submittedItemIds);
                if (count($itemsToDelete) > 0) {
                    OrderItem::whereIn('id', $itemsToDelete)->delete();
                }
            });

            return redirect()->route('order.show', $order->id)->with('success', 'Cập nhật đơn hàng thành công!');

        } catch (\Exception $e) {
            return back()->withErrors('Lỗi hệ thống: ' . $e->getMessage())->withInput();
        }
    }

    // 3. Hàm xử lý Xóa đơn hàng
    public function destroy($id)
    {
        $order = Order::findOrFail($id);

        // Bảo mật: Chỉ cho phép chủ nhân của đơn hàng mới được xóa
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Bạn không có quyền xóa đơn hàng này!');
        }

        //Chỉ cho phép xóa khi đơn hàng đang ở trạng thái 'Chờ báo giá'
        if ($order->trang_thai !== 'cho_bao_gia') {
            return back()->withErrors('Bạn chỉ có thể xóa đơn hàng đang ở trạng thái Chờ báo giá.');
        }

        try {
            DB::transaction(function () use ($order) {
                // Bước 1: Xóa toàn bộ sản phẩm (items) thuộc về đơn hàng này trước 
                // để tránh lỗi ràng buộc khóa ngoại (Foreign Key Constraint)
                OrderItem::where('order_id', $order->id)->delete();

                // Bước 2: Xóa đơn hàng cha
                $order->delete();
            });

            return redirect()->route('list.order')->with('success', 'Đã xóa đơn hàng thành công!');

        } catch (\Exception $e) {
            return back()->withErrors('Lỗi hệ thống khi xóa: ' . $e->getMessage());
        }
    }
}