<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Complaint;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;

class ComplaintController extends Controller
{
    // 1. Danh sách Khiếu nại
    public function index(Request $request)
    {
        // Load thông tin Đơn hàng, Kiện hàng và Nhân viên xử lý
        $query = Complaint::with(['order', 'package', 'nhanVienXuLy']);

        // Lọc theo trạng thái
        if ($request->filled('trang_thai')) {
            $query->where('trang_thai', $request->trang_thai);
        }

        $complaints = $query->orderByDesc('created_at')->paginate(15);
        return view('admin.complaints.index', compact('complaints'));
    }

    // 2. Chi tiết Khiếu nại
    public function show($id)
    {
        $complaint = Complaint::with(['order.user', 'package', 'nhanVienDatHang', 'nhanVienXuLy'])->findOrFail($id);
        return view('admin.complaints.show', compact('complaint'));
    }

    // 3. Form xử lý (Sửa)
    public function edit($id)
    {
        $complaint = Complaint::findOrFail($id);
        $employees = Employee::all(); // Lấy danh sách nhân viên để phân công
        return view('admin.complaints.edit', compact('complaint', 'employees'));
    }

    // 4. Lưu cập nhật xử lý
   public function update(Request $request, $id)
    {
        $complaint = Complaint::findOrFail($id);

    
        $request->validate([
            'loai_khieu_nai' => 'required|in:don_hang_cham,thai_do_khong_tot,sai_chi_phi,ship_cao,hang_thieu,hang_hu',
            'trang_thai'     => 'required|in:cho_xu_ly,da_xu_ly,da_hoan_thanh,da_huy',
            'phuong_an'      => 'nullable|in:boi_thuong,doi_tra',
            'nhan_vien_xu_ly_id' => 'nullable|exists:employees,id'
        ]);

        $nhanVienXuLyId = $request->nhan_vien_xu_ly_id ?? Auth::guard('employee')->id();

        $complaint->update([
            'loai_khieu_nai'     => $request->loai_khieu_nai,
            'trang_thai'         => $request->trang_thai,
            'phuong_an'          => $request->phuong_an,
            'nhan_vien_xu_ly_id' => $nhanVienXuLyId,
        ]);

        return redirect()->route('admin.complaints.show', $complaint->id)
                         ->with('success', 'Đã cập nhật phương án xử lý khiếu nại!');
    }

    // 5. Xoá khiếu nại
    public function destroy($id)
    {
        $complaint = Complaint::findOrFail($id);
        $complaint->delete();
        return redirect()->route('admin.complaints.index')->with('success', 'Đã xoá khiếu nại thành công!');
    }
}