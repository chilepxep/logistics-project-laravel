<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Package;
use App\Models\Warehouse;
use App\Models\ConsignmentOrder;
use App\Models\Order;

class PackageController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $packages = Package::with(['khoNhan', 'order', 'consignmentOrder'])
            ->whereHas('order', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->orWhereHas('consignmentOrder', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.package-list', compact('packages'));
    }

    public function create()
    {
        $userId = Auth::id();
        
        // Lấy danh sách kho
        $warehouses = Warehouse::all();
        
        // Lấy danh sách các đơn hàng của user này để cho phép họ liên kết
        $orders = Order::where('user_id', $userId)->orderBy('id', 'desc')->get();
        $consignmentOrders = ConsignmentOrder::where('user_id', $userId)->orderBy('id', 'desc')->get();

        return view('user.package-create', compact('warehouses', 'orders', 'consignmentOrders'));
    }

   public function store(Request $request)
    {
        
        $request->validate([
            'ma_van_don'    => 'required|string|max:50',
            'loai_hang'     => 'nullable|string|max:100',
            'tru_so_id'     => 'required|integer',
            'loai_lien_ket' => 'required|in:mua_ho,ky_gui', // Chỉ cho phép 2 giá trị này
            
            // Bắt buộc chọn Order nếu check Mua hộ
            'order_id'      => 'required_if:loai_lien_ket,mua_ho', 
            // Bắt buộc chọn Ký gửi nếu check Ký gửi
            'consignment_order_id' => 'required_if:loai_lien_ket,ky_gui',
            
            'ghi_chu'       => 'nullable|string|max:255',
        ], [
            'order_id.required_if' => 'Vui lòng chọn một Đơn mua hộ.',
            'consignment_order_id.required_if' => 'Vui lòng chọn một Đơn ký gửi.',
        ]);

        try {
            $maDonKienHang = 'PK' . time() . rand(100, 999);

            $orderId = ($request->loai_lien_ket == 'mua_ho') ? $request->order_id : null;
            $consignmentOrderId = ($request->loai_lien_ket == 'ky_gui') ? $request->consignment_order_id : null;

            Package::create([
                'ma_don_kien_hang'     => $maDonKienHang,
                'ma_van_don'           => $request->ma_van_don,
                'tru_so_id'            => $request->tru_so_id,
                'order_id'             => $orderId,
                'consignment_order_id' => $consignmentOrderId,
                'loai_hang'            => $request->loai_hang,
                'ghi_chu'              => $request->ghi_chu,
                'tinh_trang'           => 'cho_xu_ly',
            ]);

            return redirect()->route('package.index')->with('success', 'Thêm kiện hàng thành công!');

        } catch (\Exception $e) {
            return back()->withErrors('Lỗi hệ thống: ' . $e->getMessage())->withInput();
        }
    }

    public function show($id) {
        $userId = Auth::id();

        //Lấy kiện hàng kèm theo Kho, Đơn mua hộ, Đơn ký gửi và Thông tin giao hàng
        $package = Package:: with(['khoNhan', 'order', 'consignmentOrder','delivery'])->findOrFail($id);

        //Bảo mật: kiểm tra xem kiện hàng này có thuộc về đơn hàng của user đang đăng nhập không
        $isOwner = false;
        if($package-> order_id && $package->order->user_id == $userId) {
            $isOwner = true;
        } elseif ($package->consignment_order_id && $package->consignmentOrder->user_id == $userId) {
            $isOwner = true;
        }

        if (!$isOwner) {
            abort(403, 'Bạn không có quyền xem thông tin kiện hàng này!');
        }

        return view('user.package-detail', compact('package'));
    }

        public function inspection(\Illuminate\Http\Request $request)
    {
        $userId = Auth::id();

        // Khởi tạo câu truy vấn lấy kiện hàng
        $query = Package::with(['khoNhan', 'order', 'consignmentOrder'])
            ->where(function ($q) use ($userId) {
                
                // 1. Lọc kiện hàng thuộc Đơn Ký gửi CÓ yêu cầu "kiem_hang"
                $q->whereHas('consignmentOrder', function ($consignmentQuery) use ($userId) {
                    $consignmentQuery->where('user_id', $userId)
                                     ->whereHas('extraRequirements', function ($extraReq) {
                                         $extraReq->where('loai_yeu_cau', 'kiem_hang');
                                     });
                });

                
                $q->orWhereHas('order', function ($orderQuery) use ($userId) {
                    $orderQuery->where('user_id', $userId);
                });
              
            });

        // Thêm bộ lọc Trạng thái kiện hàng nếu khách hàng có chọn
        if ($request->filled('tinh_trang')) {
            $query->where('tinh_trang', $request->tinh_trang);
        }

        $packages = $query->orderBy('created_at', 'desc')->get();

        return view('user.package-inspection', compact('packages'));
    }


    public function lostPackages(\Illuminate\Http\Request $request)
    {
        // Lấy các kiện hàng KHÔNG liên kết với bất kỳ đơn nào 
        $query = \App\Models\Package::with('khoNhan')
                    ->whereNull('order_id')
                    ->whereNull('consignment_order_id');

        // Tìm kiếm chính xác hoặc gần đúng theo mã vận đơn
        if ($request->filled('ma_van_don')) {
            $query->where('ma_van_don', 'like', '%' . $request->ma_van_don . '%');
        }

        // Tìm kiếm theo kho nhận
        if ($request->filled('tru_so_id')) {
            $query->where('tru_so_id', $request->tru_so_id);
        }

        // Phân trang 15 kiện/trang
        $packages = $query->orderBy('created_at', 'desc')->paginate(15);

        // Lấy danh sách kho để đổ ra filter
        $warehouses = \App\Models\Warehouse::all();

        return view('user.package-lost', compact('packages', 'warehouses'));
    }

}