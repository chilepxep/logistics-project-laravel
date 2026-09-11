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

public function create()
{
    $countries = \App\Models\Country::all();
    return view('user.create-order', compact('countries'));
}
    
public function store(Request $request) 
{
    // 1. Kiểm tra tính hợp lệ của dữ liệu
    $request->validate([
        'country_id'          => 'required|exists:countries,id',
        'supplier_id'         => 'required|exists:suppliers,id',
        'tru_so_nhan_hang_id' => 'required|integer',
        'yeu_cau_toc_do'      => 'required|in:nhanh,thuong',
        'products'            => 'required|array|min:1',
        'products.*.ten_san_pham' => 'required|string',
        'products.*.don_gia'  => 'required|numeric|min:0',
        'products.*.so_luong' => 'required|integer|min:1',
        'extra_reqs'          => 'nullable|array',
        'extra_reqs.*'        => 'in:kiem_hang,dong_go,khai_thue_gtgt'
    ], [
        'products.*.ten_san_pham.required' => 'Bạn chưa nhập tên sản phẩm.',
        'products.*.don_gia.required'      => 'Vui lòng nhập đơn giá hợp lệ.',
        'products.*.so_luong.required'     => 'Số lượng sản phẩm không được để trống.',
        'products.required'                => 'Đơn hàng phải có ít nhất 1 sản phẩm.',
    ]);

    try {
        DB::transaction(function () use ($request) {
            
            // 2. TÍNH TOÁN TIỀN TỆ TRƯỚC KHI LƯU
            // 2.1 Tính Tổng số lượng sản phẩm & Tổng tiền Ngoại tệ
            $tongTienNgoaiTe = 0;
            $tongSoLuong = 0;

            foreach($request->products as $item) {
               $tongTienNgoaiTe += ($item['don_gia'] * $item['so_luong']);
               $tongSoLuong += $item['so_luong'];
            }

            // 2.2 Lấy Tỉ giá của Quốc gia (Đảm bảo model Country đã use ở trên)
            $country = \App\Models\Country::findOrFail($request->country_id);
            
            // Chuyển đổi mã tiền tệ sang Tỉ giá cố định (Bạn có thể kéo từ DB nếu sau này có bảng Tỉ Giá)
            $tiGia = 3500; // Mặc định là Tệ (CNY)
            if ($country->tien_te == 'JPY') $tiGia = 170;
            if ($country->tien_te == 'AUD') $tiGia = 16500;
            if ($country->tien_te == 'EUR') $tiGia = 27000;

            // 2.3 Tính các loại tiền (VNĐ)
            $tienHangVnd = $tongTienNgoaiTe * $tiGia;
            
            $phiMuaHoVnd = $tienHangVnd * 0.01; // Phí mua hộ 1%
            
            $phiDichVuVnd = 0;
            if ($request->has('extra_reqs')) {
                if (in_array('kiem_hang', $request->extra_reqs)) {
                    $phiDichVuVnd += ($tongSoLuong * 1000); // 1000đ/1 SP
                }
                if (in_array('dong_go', $request->extra_reqs)) {
                    $phiDichVuVnd += ($tongSoLuong * 5000); // 5000đ/1 SP
                }
            }

            // 2.4 CỘNG DỒN TẤT CẢ TẠO THÀNH GRAND TOTAL
            $tongTienThanhToan = $tienHangVnd + $phiMuaHoVnd + $phiDichVuVnd;


            // 3. LƯU THÔNG TIN VÀO BẢNG ORDER
            $order = Order::create([
                'ma_don_hang'         => 'MH' . time() . rand(10, 99),
                'user_id'             => Auth::id(),
                'country_id'          => $request->country_id,  
                'supplier_id'         => $request->supplier_id,
                'tru_so_nhan_hang_id' => $request->tru_so_nhan_hang_id,
                'yeu_cau_toc_do'      => $request->yeu_cau_toc_do,
                
                // Ở đây ta lưu TỔNG TIỀN VNĐ CUỐI CÙNG thay vì tiền Ngoại tệ
                'tong_tien'           => $tongTienThanhToan, 
                
                'trang_thai'          => 'cho_xu_ly'
            ]);

            // 4. LƯU CHI TIẾT SẢN PHẨM
            foreach($request->products as $index => $item) {
                $hinhAnhUrl = null;

                if ($request->hasFile("products.{$index}.hinh_anh_file")) {
                    $file = $request->file("products.{$index}.hinh_anh_file");
                    $path = $file->store('uploads/orders', 'public');
                    $hinhAnhUrl = '/storage/' . $path; 
                } 
                elseif (!empty($item['hinh_anh_url'])) {
                    $hinhAnhUrl = $item['hinh_anh_url'];
                }

                OrderItem::create([
                    'order_id'           => $order->id,
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

            // 5. LƯU DỊCH VỤ GIA TĂNG
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

    } catch (\Exception $e) {
        return back()->withErrors('Lỗi hệ thống: ' . $e->getMessage())->withInput(); 
    }
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