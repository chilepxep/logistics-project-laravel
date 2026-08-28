<?php

namespace App\Http\Controllers;

use App\Models\ConsignmentOrder; 
use App\Models\ConsignmentOrderItem;
use App\Models\ConsignmentExtraRequirement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Warehouse;

class ConsignmentController extends Controller
{
    public function store(Request $request)
    {
        // 1. Kiểm tra dữ liệu đầu vào (Validation)
       $request->validate([
            'tru_so_nhan_hang_id'       => 'required|integer',
            'packages'                  => 'required|array|min:1',
            'packages.*.ma_van_don'     => 'required|string',
            'packages.*.ten_san_pham'   => 'required|string',
            'packages.*.so_kien_hang'   => 'required|integer|min:1',
            'packages.*.hang_van_chuyen'=> 'required|string',
            'packages.*.so_luong'       => 'required|integer|min:1',
            'packages.*.gia_tri_hang_hoa'=> 'required|numeric|min:0',
            'packages.*.loai_danh_muc'  => 'required|string',
            'packages.*.tq_vn'          => 'required|string',
            'packages.*.link_san_pham'  => 'nullable|string', 
            'packages.*.mo_ta_chi_tiet' => 'nullable|string', 
            'packages.*.ghi_chu'        => 'nullable|string'  
        ]);

        try {
            DB::transaction(function () use ($request) {
                
                // 1. Tạo đơn hàng (Bảng Cha)
                // Lấy yêu cầu tốc độ từ kiện hàng đầu tiên (nếu có), mặc định là 'thuong'
                $tocDo = $request->packages[1]['yeu_cau_toc_do'] ?? 'thuong'; 

                $order = ConsignmentOrder::create([
                    'ma_don_ky_gui'    => 'KG' . time() . rand(10, 99),
                    'user_id'          => Auth::id(),
                    'ngay_tao_yeu_cau' => now()->toDateString(),
                    'kho_nhan_tq_id'   => $request->tru_so_nhan_hang_id,
                    'so_kien'          => count($request->packages),
                    'yeu_cau_toc_do'   => $tocDo,
                    'trang_thai'       => 'cho_xu_ly'
                ]);

                $hasDongGo = false; // Biến cờ kiểm tra xem có kiện nào yêu cầu đóng gỗ không

                // 2. Lưu chi tiết từng kiện hàng
                $stt = 1;
                foreach ($request->packages as $index => $pkg) {
                    $hinhAnhUrl = null;

                    if ($request->hasFile("packages.{$index}.hinh_anh_file")) {
                        $file = $request->file("packages.{$index}.hinh_anh_file");
                        $path = $file->store('uploads/consignments', 'public');
                        $hinhAnhUrl = '/storage/' . $path;
                    }

                    ConsignmentOrderItem::create([
                        'consignment_order_id' => $order->id,
                        'stt'                  => $stt++,
                        'hinh_anh_url'         => $hinhAnhUrl,
                        'ma_van_don'           => $pkg['ma_van_don'],
                        'ten_san_pham'         => $pkg['ten_san_pham'],
                        'so_kien_hang'         => $pkg['so_kien_hang'],
                        'hang_van_chuyen'      => $pkg['hang_van_chuyen'],
                        
                    
                        'tq_vn'                => $pkg['tq_vn'] ?? 'TQ-VN',
                        'loai_danh_muc'        => $pkg['loai_danh_muc'] ?? null,
                        'so_luong'             => $pkg['so_luong'],
                        'gia_tri_hang_hoa'     => $pkg['gia_tri_hang_hoa'], 
                        'link_san_pham'        => $pkg['link_san_pham'] ?? null,
                        
                        'ghi_chu'              => $pkg['ghi_chu'] ?? null,
                    ]);
                    // Kiểm tra nếu khách hàng tick Đóng gỗ ở kiện này
                    if (isset($pkg['dong_go'])) {
                        $hasDongGo = true;
                    }
                }

                // 3. Lưu Dịch vụ gia tăng (Bảng Extra Requirements)
                if ($hasDongGo) {
                    ConsignmentExtraRequirement::create([
                        'consignment_order_id' => $order->id,
                        'loai_yeu_cau'         => 'dong_go'
                    ]);
                }
            });

            return back()->with('success', 'Tạo đơn ký gửi thành công!');

        } catch (\Exception $e) {
            return back()->withErrors('Lỗi hệ thống: ' . $e->getMessage())->withInput();
        }
    }

    public function index()
    {
        $userId = Auth::id();

        // Lấy danh sách ký gửi kèm thông tin kho, sắp xếp mới nhất lên đầu
        $consignmentOrders = ConsignmentOrder::with('khoNhan')
                                             ->where('user_id', $userId)
                                             ->orderBy('created_at', 'desc')
                                             ->get();

        return view('user.consignment-list', compact('consignmentOrders'));
    }

    public function show($id)
    {
        // Lấy đơn ký gửi kèm theo kho nhận, các kiện hàng và yêu cầu gia tăng
        $order = ConsignmentOrder::with(['khoNhan', 'items', 'extraRequirements'])->findOrFail($id);

        // Bảo mật: Chỉ chủ nhân của đơn mới được xem
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Bạn không có quyền xem đơn ký gửi này!');
        }

        return view('user.consignment-detail', compact('order'));
    }

    // 1. Giao diện sửa đơn ký gửi
    public function edit($id)
    {
        $order = ConsignmentOrder::with(['items', 'extraRequirements'])->findOrFail($id);

        if ($order->user_id !== Auth::id()) {
            abort(403, 'Bạn không có quyền sửa đơn hàng này!');
        }

        // Chỉ cho phép sửa khi đơn đang chờ xử lý
        if ($order->trang_thai !== 'cho_xu_ly') {
            return redirect()->route('consignment.index')->withErrors('Chỉ được sửa đơn hàng đang ở trạng thái Chờ xử lý.');
        }

        // Lấy danh sách kho để hiển thị ra Select box
        $warehouses = Warehouse::all(); // Hoặc Warehouse::where('loai_kho', 'TQ')->get() nếu bạn có phân loại

        return view('user.consignment-edit', compact('order', 'warehouses'));
    }

    // 2. Logic cập nhật dữ liệu
    public function update(Request $request, $id)
    {
        $order = ConsignmentOrder::findOrFail($id);

        if ($order->user_id !== Auth::id()) abort(403);

        $request->validate([
            'tru_so_nhan_hang_id'       => 'required|integer',
            'packages'                  => 'required|array|min:1',
            'packages.*.ma_van_don'     => 'required|string',
            'packages.*.ten_san_pham'   => 'required|string',
            'packages.*.so_kien_hang'   => 'required|integer|min:1',
            'packages.*.hang_van_chuyen'=> 'required|string',
            'packages.*.so_luong'       => 'required|integer|min:1',
            'packages.*.gia_tri_hang_hoa'=> 'required|numeric|min:0',
            'packages.*.loai_danh_muc'  => 'required|string',
            'packages.*.tq_vn'          => 'required|string',
            'packages.*.link_san_pham'  => 'nullable|string',
            'packages.*.ghi_chu'        => 'nullable|string'
        ]);

        try {
            DB::transaction(function () use ($request, $order) {
                
                // 1. Cập nhật bảng cha
                $tocDo = $request->packages[array_key_first($request->packages)]['yeu_cau_toc_do'] ?? 'thuong';
                $order->update([
                    'kho_nhan_tq_id' => $request->tru_so_nhan_hang_id,
                    'so_kien'        => count($request->packages),
                    'yeu_cau_toc_do' => $tocDo,
                ]);

                // 2. Cập nhật các kiện hàng (Thêm/Sửa/Xóa)
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
                        'tq_vn'                => $pkg['tq_vn'] ?? 'TQ-VN',
                        'loai_danh_muc'        => $pkg['loai_danh_muc'] ?? null,
                        'so_luong'             => $pkg['so_luong'],
                        'gia_tri_hang_hoa'     => $pkg['gia_tri_hang_hoa'], 
                        'link_san_pham'        => $pkg['link_san_pham'] ?? null,
                        'ghi_chu'              => $pkg['ghi_chu'] ?? null,
                    ];

                    if (!empty($pkg['id'])) {
                        // Sửa kiện hàng cũ
                        $orderItem = ConsignmentOrderItem::find($pkg['id']);
                        if ($orderItem && $orderItem->consignment_order_id == $order->id) {
                            $orderItem->update($dataItem);
                            $submittedItemIds[] = $orderItem->id;
                        }
                    } else {
                        // Thêm kiện hàng mới
                        $dataItem['consignment_order_id'] = $order->id;
                        $newItem = ConsignmentOrderItem::create($dataItem);
                        $submittedItemIds[] = $newItem->id;
                    }

                    // Bắt sự kiện Dịch vụ gia tăng
                    if (isset($pkg['dong_go'])) $hasDongGo = true;
                    if (isset($pkg['kiem_hang'])) $hasKiemHang = true;
                }

                // Xóa các kiện hàng không còn tồn tại trên form
                $itemsToDelete = array_diff($existingItemIds, $submittedItemIds);
                if (count($itemsToDelete) > 0) {
                    ConsignmentOrderItem::whereIn('id', $itemsToDelete)->delete();
                }

                // 3. Cập nhật Dịch vụ gia tăng
                // Xóa toàn bộ yêu cầu cũ của đơn này và tạo lại cho gọn nhẹ
                ConsignmentExtraRequirement::where('consignment_order_id', $order->id)->delete();
                
                if ($hasDongGo) {
                    ConsignmentExtraRequirement::create(['consignment_order_id' => $order->id, 'loai_yeu_cau' => 'dong_go']);
                }
                if ($hasKiemHang) {
                    ConsignmentExtraRequirement::create(['consignment_order_id' => $order->id, 'loai_yeu_cau' => 'kiem_hang']);
                }
            });

            return redirect()->route('consignment.show', $order->id)->with('success', 'Cập nhật đơn ký gửi thành công!');

        } catch (\Exception $e) {
            return back()->withErrors('Lỗi hệ thống: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        $order = ConsignmentOrder::findOrFail($id);

        // Bảo mật: Kiểm tra xem user có phải là chủ đơn hàng không
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Bạn không có quyền xóa đơn hàng này!');
        }

        //cho phép xóa khi đơn đang ở trạng thái 'Chờ xử lý'
        if ($order->trang_thai !== 'cho_xu_ly') {
            return back()->withErrors('Bạn chỉ có thể xóa đơn hàng đang ở trạng thái Chờ xử lý.');
        }

        try {
            DB::transaction(function () use ($order) {
                // Bước 1: Xóa chi tiết các kiện hàng
                ConsignmentOrderItem::where('consignment_order_id', $order->id)->delete();

                // Bước 2: Xóa các yêu cầu dịch vụ gia tăng (đóng gỗ, kiểm hàng...)
                ConsignmentExtraRequirement::where('consignment_order_id', $order->id)->delete();

                // Bước 3: Xóa đơn hàng cha
                $order->delete();
            });

            return redirect()->route('consignment.index')->with('success', 'Đã xóa đơn ký gửi thành công!');

        } catch (\Exception $e) {
            return back()->withErrors('Lỗi hệ thống khi xóa: ' . $e->getMessage());
        }
    }
}