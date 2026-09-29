<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Warehouse;

class EmployeeController extends Controller
{
   public function index()
    {
        $employees = Employee::with('warehouse')->orderByDesc('created_at')->paginate(15);
        return view('admin.employees.index', compact('employees'));
    }

    public function create()
    {
        $warehouses = Warehouse::all();
        return view('admin.employees.create', compact('warehouses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ma_nv'    => 'required|unique:employees,ma_nv',
            'ho_ten'   => 'required|string|max:255',
            'email'    => 'required|email|unique:employees,email',
            'password' => 'required|min:6',
            'vai_tro'  => 'required',
            'warehouse_id' => 'nullable|integer',
            'is_approved'  => 'nullable'
        ]);

        Employee::create([
            'ma_nv'    => $request->ma_nv,
            'ho_ten'   => $request->ho_ten,
            'email'    => $request->email,
            'password' => Hash::make($request->password), // Mã hoá mật khẩu
            'vai_tro'  => $request->vai_tro,
            'warehouse_id' => $request->warehouse_id,
            'is_approved'  => $request->boolean('is_approved'),
        ]);

        return redirect()->route('admin.employees.index')->with('success', 'Thêm nhân viên thành công!');
    }

    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        $warehouses = Warehouse::all();
        return view('admin.employees.edit', compact('employee', 'warehouses'));
    }

    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);

        $request->validate([
            'ma_nv'    => 'required|unique:employees,ma_nv,' . $id,
            'ho_ten'   => 'required|string|max:255',
            'email'    => 'required|email|unique:employees,email,' . $id,
            'password' => 'nullable|min:6', 
            'vai_tro'  => 'required',
            'warehouse_id' => 'nullable|integer',
            'is_approved'  => 'nullable'
        ]);

        $data = [
            'ma_nv'   => $request->ma_nv,
            'ho_ten'  => $request->ho_ten,
            'email'   => $request->email,
            'vai_tro' => $request->vai_tro,
            'warehouse_id' => $request->warehouse_id,
            'is_approved'  => $request->boolean('is_approved'),
        ];

        // Chỉ cập nhật mật khẩu nếu người dùng có nhập mật khẩu mới
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $employee->update($data);

        return redirect()->route('admin.employees.index')->with('success', 'Cập nhật thành công!');
    }

    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        
        // Không cho phép tài khoản đang đăng nhập tự xoá chính mình
        if (Auth::guard('employee')->id() == $id) {
            return back()->withErrors('Bạn không thể tự xoá chính tài khoản của mình!');
        }

        $employee->delete();
        return back()->with('success', 'Đã xoá nhân viên!');
    }
}