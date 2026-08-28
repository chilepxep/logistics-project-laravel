<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderExtraRequirement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\ConsignmentOrder;
use Illuminate\Pagination\LengthAwarePaginator;

class OrderController extends Controller
{
    public function store(Request $request) {
        //1 kiểm tra tính hợp lệ của dữ liệu
        $request->validate([
            'tru_so_nhan_hang_id' => 'required|integer',
            'yeu_cau_toc_do'      => 'required|in:nhanh,thuong',
            'products'            => 'required|array|min:1',
            'products.*.ten_san_pham' => 'required|string',
            'products.*.don_gia'  => 'required|numeric|min:0',
            'products.*.so_luong' => 'required|integer|min:1',
            'extra_reqs'   => 'nullable|array',
'extra_reqs.*' => 'in:kiem_hang,dong_go,khai_thue_gtgt'

        ], [
            'products.*.ten_san_pham.required' => 'Bạn chưa nhập tên sản phẩm cho một số món hàng.',
    'products.*.don_gia.required'      => 'Vui lòng nhập đơn giá hợp lệ.',
    'products.*.so_luong.required'     => 'Số lượng sản phẩm không được để trống.',
    'products.required'                => 'Đơn hàng phải có ít nhất 1 sản phẩm.',
        ]);
        try {
          DB::transaction(function () use ($request) {
            //2 tính toán tổng tiền của đơn hàng
            $tongTien = 0;
            foreach($request->products as $item){
               $tongTien += ($item['don_gia'] * $item['so_luong']);
            }

            //3 lưu thông tin chung vào bảng order
            $order = Order::create([
                'ma_don_hang'         => 'MH' . time() . rand(10, 99),
                'user_id'             => Auth::id(),
                'tru_so_nhan_hang_id' => $request->tru_so_nhan_hang_id,
                'yeu_cau_toc_do'      => $request->yeu_cau_toc_do,
                'tong_tien'           => $tongTien,
                'trang_thai'          => 'cho_bao_gia'
            ]);

            //4 lưu từng sản phẩm vào bảng order_item
            foreach($request->products as $index => $item) {
                $hinhAnhUrl = null;

                // 1. Kiểm tra xem người dùng có upload FILE ẢNH hay không
    if ($request->hasFile("products.{$index}.hinh_anh_file")) {
        $file = $request->file("products.{$index}.hinh_anh_file");
        // Lưu ảnh vào thư mục 'public/uploads/orders'
        $path = $file->store('uploads/orders', 'public');
        $hinhAnhUrl = '/storage/' . $path; // Đường dẫn xuất ra web
    } 
    // 2. Nếu không có file, kiểm tra xem họ có dán LINK ẢNH không
    elseif (!empty($item['hinh_anh_url'])) {
        $hinhAnhUrl = $item['hinh_anh_url'];
    }
                OrderItem::create([
                    'order_id' => $order->id,
                    'stt'                => $index + 1,
                    'hinh_anh_url'       => $hinhAnhUrl,
                    'ten_san_pham'       => $item['ten_san_pham'],
                    'mau_sac_kich_thuoc' => $item['thuoc_tinh'] ?? null,
                    'link_san_pham'      => $item['link_san_pham'] ?? null,
                    'don_gia'            => $item['don_gia'],
                    'so_luong'           => $item['so_luong'],
                    'ghi_chu_khac'       => $item['ghi_chu'] ?? null,
                ]);
            }

            //5 Luu các dich vu gia tang (kiem hang, đóng gỗ)
            if($request->has('extra_reqs')) {
                foreach($request->extra_reqs as $req) {
                    OrderExtraRequirement::create([
                            'order_id'     => $order->id,
                            'loai_yeu_cau' => $req
                        ]);
                }
            }
           
          });
          return back()->with('success', 'Tạo đơn hàng thành công!');
          }
        catch (\Exception $e) {
          return back()->withErrors('Lỗi hệ thống: ' . $e->getMessage())->withInput(); 
        };
    }


    public function allOrders(Request $request)
    {
        $userId = Auth::id();

        // 1. Lấy danh sách Đơn mua hộ và chuẩn hóa thuộc tính
        $orders = Order::where('user_id', $userId)
            ->get()
            ->map(function ($item) {
                $item->loai_don = 'mua_ho';
                $item->ma_hien_thi = $item->ma_don_hang ?? ('DH-' . $item->id);
                $item->trang_thai_hien_thi = $item->trang_thai;
                return $item;
            });

        // 2. Lấy danh sách Đơn ký gửi và chuẩn hóa thuộc tính
        $consignmentOrders = ConsignmentOrder::where('user_id', $userId)
            ->get()
            ->map(function ($item) {
                $item->loai_don = 'ky_gui';
                $item->ma_hien_thi = $item->ma_don_ky_gui ?? ('KG-' . $item->id);
                $item->trang_thai_hien_thi = $item->tinh_trang;
                return $item;
            });

        // 3. Gom chung (Concat) 2 danh sách lại và sắp xếp mới nhất lên đầu
        $merged = $orders->concat($consignmentOrders)->sortByDesc('created_at');

        // 4. Bộ lọc theo Loại đơn nếu người dùng chọn trên giao diện
        if ($request->filled('loai')) {
            $merged = $merged->where('loai_don', $request->loai);
        }

        // 5. Phân trang thủ công cho Collection (15 dòng / trang)
        $perPage = 15;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = $merged->slice(($currentPage - 1) * $perPage, $perPage)->values();
        
        $allOrders = new LengthAwarePaginator(
            $currentItems,
            $merged->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('user.all-orders', compact('allOrders'));
    }
}