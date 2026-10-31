<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderExtraRequirement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


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

            // 2.2 Lấy thông tin Quốc gia
            $country = \App\Models\Country::findOrFail($request->country_id);

            // Lấy tỉ giá hiện tại từ bảng ExchangeRate dựa theo mã tiền tệ (VD: CNY, JPY)
            $exchangeRate = \App\Models\ExchangeRate::where('currency_code', $country->tien_te)->first();
            
            if ($exchangeRate) {
                $tiGia = (float) $exchangeRate->rate;
            } else {
                $defaultRate = \App\Models\ExchangeRate::where('is_default', 1)->first();
                $tiGia = $defaultRate ? (float) $defaultRate->rate : 3520; 
            }

            // 2.3 Tính các loại tiền (VNĐ)
            $tienHangVnd = $tongTienNgoaiTe * $tiGia;

            // Tính phí mua hộ (Ví dụ: 1%)
            $phiMuaHoVnd = $tienHangVnd * 0.01; 

            // Tính phí mua hộ 
            $tyLePhiMuaHo = config('fees.phi_dat_hang_percent');
            $phiMuaHoVnd = $tienHangVnd * $tyLePhiMuaHo;
            
            // Tính phí dịch vụ
            $phiDichVuVnd = 0;
            if ($request->has('extra_reqs')) {
                if (in_array('kiem_hang', $request->extra_reqs)) {
                    $phiDichVuVnd += ($tongSoLuong * config('fees.phi_kiem_dem_per_item')); 
                }
                if (in_array('dong_go', $request->extra_reqs)) {
                    $phiDichVuVnd += ($tongSoLuong * config('fees.phi_dong_go_per_item')); 
                }
            }

            // 2.4 CỘNG DỒN ĐỂ TẠO TỔNG TIỀN (Khớp tuyệt đối với Javascript)
            $tongTienThanhToan = $tienHangVnd + $phiMuaHoVnd + $phiDichVuVnd;


            // 3. LƯU THÔNG TIN VÀO BẢNG ORDER
            $order = Order::create([
                'ma_don_hang'         => 'MH' . time() . rand(10, 99),
                'user_id'             => Auth::id(),
                'country_id'          => $request->country_id,  
                'supplier_id'         => $request->supplier_id,
                'tru_so_nhan_hang_id' => $request->tru_so_nhan_hang_id,
                'yeu_cau_toc_do'      => $request->yeu_cau_toc_do,
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
        $query = \App\Models\Package::with(['order', 'consignmentOrder'])
            ->where(function ($q) use ($userId) {
                $q->whereHas('order', function ($sub) use ($userId) {
                    $sub->where('user_id', $userId);
                })->orWhereHas('consignmentOrder', function ($sub) use ($userId) {
                    $sub->where('user_id', $userId);
                });
            })
            ->orderByDesc('created_at');

        // 2. Lọc theo Loại đơn từ giao diện 
        if ($request->filled('loai')) {
            if ($request->loai === 'mua_ho') {
                $query->whereNotNull('order_id');
            } elseif ($request->loai === 'ky_gui') {
                $query->whereNotNull('consignment_order_id');
            }
        }

        // 3. Phân trang trực tiếp bằng Eloquent
        $allOrders = $query->paginate(15)->withQueryString();

        // 4. Thống kê Summary 
        $summaryData = \App\Models\Package::where(function ($q) use ($userId) {
                $q->whereHas('order', function ($sub) use ($userId) {
                    $sub->where('user_id', $userId);
                })->orWhereHas('consignmentOrder', function ($sub) use ($userId) {
                    $sub->where('user_id', $userId);
                });
            })->select('tinh_trang')->get();

        $summary = [
            'cho_xu_ly'       => $summaryData->where('tinh_trang', 'cho_xu_ly')->count(),
            'da_nhap_kho'     => $summaryData->where('tinh_trang', 'da_nhap_kho')->count(),
            'dang_luan_chuyen'=> $summaryData->where('tinh_trang', 'dang_van_chuyen')->count(),
            'dang_giao_hang'  => $summaryData->where('tinh_trang', 'dang_giao_hang')->count(),
            'khach_da_nhan'   => $summaryData->where('tinh_trang', 'hoan_thanh')->count(),
            'yeu_cau_tra_hang'=> $summaryData->where('tinh_trang', 'tra_hang')->count(),
        ];

        $deliveryCount = \App\Models\Delivery::where('trang_thai', '!=', 'thanh_cong')
    ->whereHas('package', function ($q) use ($userId) {
        $q->whereHas('order', function ($sub) use ($userId) {
            $sub->where('user_id', $userId);
        })->orWhereHas('consignmentOrder', function ($sub) use ($userId) {
            $sub->where('user_id', $userId);
        });
    })->count();
        return view('user.all-orders', compact('allOrders', 'summary', 'deliveryCount'));
    }
}