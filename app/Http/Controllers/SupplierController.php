<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;
use App\Models\SupplierContact;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        //Khởi tạo truy vấn, gọi kèm danh sách liên hệ để tránh N+1 Query
        $query = Supplier::with('contacts');

        //Tìm kiếm theo tên hoặc mã nhà cung cấp
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function($q) use ($keyword) {
                $q->where('ten_ncc', 'like', "%{$keyword}%")
                  ->orWhere('ma_ncc', 'like', "%{$keyword}%");
            });
        }

        $suppliers = $query->orderBy('created_at', 'desc')->paginate(12);

        return view('user.supplier-list', compact('suppliers'));
    }

    public function create()
    {
        // Tự động sinh mã NCC gợi ý 
        $suggestedCode = 'NCC' . time();
        return view('user.supplier-create', compact('suggestedCode'));
    }

    // 2. Xử lý lưu dữ liệu
    public function store(Request $request)
    {
        // Validate dữ liệu
        $request->validate([
            'ma_ncc'             => 'required|string|max:20|unique:suppliers,ma_ncc',
            'ten_ncc'            => 'required|string|max:150',
            'hinh_thuc'          => 'required|in:online,offline',
            'logo_file'          => 'nullable|image|max:2048', // Ảnh tối đa 2MB
            'contacts'           => 'nullable|array',
            'contacts.*.loai'    => 'required|in:email,qq,sdt,wechat',
            'contacts.*.gia_tri' => 'required|string|max:150',
        ], [
            'ma_ncc.unique' => 'Mã nhà cung cấp này đã tồn tại trong hệ thống.'
        ]);

        try {
            DB::transaction(function () use ($request) {
                // 1. Xử lý upload Logo
                $logoUrl = null;
                if ($request->hasFile('logo_file')) {
                    $path = $request->file('logo_file')->store('uploads/suppliers', 'public');
                    $logoUrl = '/storage/' . $path;
                }

                // 2. Tạo Nhà cung cấp (Bảng cha)
                $supplier = Supplier::create([
                    'ma_ncc'             => $request->ma_ncc,
                    'ten_ncc'            => $request->ten_ncc,
                    'nganh_hang'         => $request->nganh_hang,
                    'hinh_thuc'          => $request->hinh_thuc,
                    'logo_url'           => $logoUrl,
                    'ten_nguoi_dai_dien' => $request->ten_nguoi_dai_dien,
                    'chuc_vu'            => $request->chuc_vu,
                    'chi_tiet'           => $request->chi_tiet,
                    'ten_ngan_hang'      => $request->ten_ngan_hang,
                    'so_tai_khoan'       => $request->so_tai_khoan,
                    'chu_tai_khoan'      => $request->chu_tai_khoan,
                    'chi_nhanh'          => $request->chi_nhanh,
                ]);

                // 3. Thêm các phương thức liên lạc (Bảng con)
                if ($request->has('contacts')) {
                    foreach ($request->contacts as $contact) {
                        SupplierContact::create([
                            'supplier_id' => $supplier->id,
                            'loai'        => $contact['loai'],
                            'gia_tri'     => $contact['gia_tri']
                        ]);
                    }
                }
            });

            return redirect()->route('supplier.index')->with('success', 'Thêm Nhà cung cấp thành công!');

        } catch (\Exception $e) {
            return back()->withErrors('Lỗi hệ thống: ' . $e->getMessage())->withInput();
        }
    }
}