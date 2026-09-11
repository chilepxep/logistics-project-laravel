<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class CustomerController extends Controller
{
    // 1. Danh sách Khách hàng
    public function index(Request $request)
    {
        $query = User::query();

        // Xử lý tìm kiếm theo Tên, Mã tài khoản hoặc Số điện thoại
        if ($request->filled('keyword')) {
            $kw = $request->keyword;
            $query->where('ho_ten', 'like', "%{$kw}%")
                  ->orWhere('ma_tai_khoan', 'like', "%{$kw}%")
                  ->orWhere('sdt', 'like', "%{$kw}%");
        }

        $customers = $query->orderByDesc('created_at')->paginate(15);
        return view('admin.customers.index', compact('customers'));
    }

    // 2. Hồ sơ chi tiết Khách hàng
    public function show($id)
    {
        // Load User kèm theo toàn bộ Lịch sử
        $customer = User::with([
            'orders' => function($q) { $q->orderByDesc('created_at'); },
            'consignmentOrders' => function($q) { $q->orderByDesc('created_at'); },
            'transactions' => function($q) { $q->orderByDesc('thoi_gian'); },
            'withdrawals' => function($q) { $q->orderByDesc('ngay_yeu_cau'); }
        ])->findOrFail($id);

        return view('admin.customers.show', compact('customer'));
    }

    // 3. Form sửa thông tin
    public function edit($id)
    {
        $customer = User::findOrFail($id);
        return view('admin.customers.edit', compact('customer'));
    }

    // 4. Lưu cập nhật
   public function update(Request $request, $id)
    {
        $customer = User::findOrFail($id);

        $request->validate([
            'ho_ten' => 'required|string|max:255',
            'sdt'    => 'nullable|string|max:20',
            // Check email không trùng với người khác
            'email'  => 'required|email|unique:users,email,' . $id,
        ]);

        $customer->update($request->only([
            'ho_ten', 'sdt', 'email', 'ngay_sinh', 'gioi_tinh', 
            'dia_chi', 'tinh_thanh', 'loai_van_chuyen_mac_dinh'
        ]));

        return redirect()->route('admin.customers.show', $customer->id)
                         ->with('success', 'Đã cập nhật thông tin khách hàng!');
    }

    // Xử lý Khoá / Mở khoá tài khoản
    public function toggleLock($id)
    {
        $customer = User::findOrFail($id);
        
        
        $customer->is_locked = !$customer->is_locked;
        $customer->save();

        $status = $customer->is_locked ? 'Khoá' : 'Mở khoá';
        
        return back()->with('success', "Đã $status tài khoản của khách hàng {$customer->ho_ten} thành công!");
    }
}