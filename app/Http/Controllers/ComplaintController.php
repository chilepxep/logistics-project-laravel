<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Complaint;

class ComplaintController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();

        // Lấy khiếu nại thuộc Đơn hoặc Kiện hàng của User này
        $query = Complaint::with(['order', 'package'])->where(function ($q) use ($userId) {
            $q->whereHas('order', function ($orderQuery) use ($userId) {
                $orderQuery->where('user_id', $userId);
            })->orWhereHas('package.order', function ($pkgOrder) use ($userId) {
                $pkgOrder->where('user_id', $userId);
            })->orWhereHas('package.consignmentOrder', function ($pkgConsign) use ($userId) {
                $pkgConsign->where('user_id', $userId);
            });
        });

        //Lọc theo khoảng thời gian
        if ($request->filled('tu_ngay')) {
            $query->whereDate('created_at', '>=', $request->tu_ngay);
        }
        if ($request->filled('den_ngay')) {
            $query->whereDate('created_at', '<=', $request->den_ngay);
        }

        //ĐẾM THỐNG KÊ TRẠNG THÁI 
        $statusCounts = (clone $query)
            ->selectRaw('trang_thai, count(*) as total')
            ->groupBy('trang_thai')
            ->pluck('total', 'trang_thai')
            ->toArray();

        $summary = [
            'cho_xu_ly'     => $statusCounts['cho_xu_ly'] ?? 0,
            'da_xu_ly'      => $statusCounts['da_xu_ly'] ?? 0,
            'da_hoan_thanh' => $statusCounts['da_hoan_thanh'] ?? 0,
            'da_huy'        => $statusCounts['da_huy'] ?? 0,
            'tong'          => array_sum($statusCounts)
        ];

        //Lấy danh sách kết quả
        $complaints = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('user.complaint-list', compact('complaints', 'summary'));
    }


    public function create()
    {
        $userId = Auth::id();
        
        // Lấy danh sách Đơn mua hộ của user
        $orders = \App\Models\Order::where('user_id', $userId)->orderBy('created_at', 'desc')->get();
        
        // Lấy danh sách Kiện hàng (cả Mua hộ & Ký gửi) của user
        $packages = \App\Models\Package::whereHas('order', function($q) use($userId) {
            $q->where('user_id', $userId);
        })->orWhereHas('consignmentOrder', function($q) use($userId) {
            $q->where('user_id', $userId);
        })->orderBy('created_at', 'desc')->get();

        return view('user.complaint-create', compact('orders', 'packages'));
    }

    public function store(Request $request)
    {
        // Kiểm tra dữ liệu đầu vào
        $request->validate([
            'loai_lien_ket'  => 'required|in:don_hang,kien_hang',
            'order_id'       => 'required_if:loai_lien_ket,don_hang',
            'package_id'     => 'required_if:loai_lien_ket,kien_hang',
            'loai_khieu_nai' => 'required|in:don_hang_cham,thai_do_khong_tot,sai_chi_phi,ship_cao,hang_thieu,hang_hu',
            'phuong_an'      => 'nullable|in:boi_thuong,doi_tra',
            'hinh_anh_file'  => 'nullable|image|max:5120' // Max 5MB
        ], [
            'order_id.required_if' => 'Vui lòng chọn một đơn hàng.',
            'package_id.required_if' => 'Vui lòng chọn một kiện hàng.',
            'hinh_anh_file.image' => 'File tải lên phải là hình ảnh.',
            'hinh_anh_file.max' => 'Kích thước ảnh tối đa là 5MB.'
        ]);

        try {
            // Xử lý upload hình ảnh bằng chứng
            $hinhAnhUrl = null;
            if ($request->hasFile('hinh_anh_file')) {
                $file = $request->file('hinh_anh_file');
                $path = $file->store('uploads/complaints', 'public');
                $hinhAnhUrl = '/storage/' . $path;
            }

            // Lưu dữ liệu vào Database
            Complaint::create([
                'order_id'       => $request->loai_lien_ket == 'don_hang' ? $request->order_id : null,
                'package_id'     => $request->loai_lien_ket == 'kien_hang' ? $request->package_id : null,
                'loai_khieu_nai' => $request->loai_khieu_nai,
                'phuong_an'      => $request->phuong_an,
                'hinh_anh_url'   => $hinhAnhUrl,
                'trang_thai'     => 'cho_xu_ly'
            ]);

            return redirect()->route('complaint.index')->with('success', 'Gửi khiếu nại thành công! HTKK sẽ phản hồi bạn trong thời gian sớm nhất.');

        } catch (\Exception $e) {
            return back()->withErrors('Lỗi hệ thống: ' . $e->getMessage())->withInput();
        }
    }

    


}