<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
   public function index()
    {
        $employees = Employee::orderByDesc('created_at')->paginate(15);
        return view('admin.employees.index', compact('employees'));
    }

    public function create()
    {
        return view('admin.employees.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'ma_nv'    => 'required|unique:employees,ma_nv',
            'ho_ten'   => 'required|string|max:255',
            'email'    => 'required|email|unique:employees,email',
            'password' => 'required|min:6',
            'vai_tro'  => 'required'
        ]);

        Employee::create([
            'ma_nv'    => $request->ma_nv,
            'ho_ten'   => $request->ho_ten,
            'email'    => $request->email,
            'password' => Hash::make($request->password), // Mã hoá mật khẩu
            'vai_tro'  => $request->vai_tro,
        ]);

        return redirect()->route('admin.employees.index')->with('success', 'Thêm nhân viên thành công!');
    }

    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        return view('admin.employees.edit', compact('employee'));
    }

    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);

        $request->validate([
            'ma_nv'    => 'required|unique:employees,ma_nv,' . $id,
            'ho_ten'   => 'required|string|max:255',
            'email'    => 'required|email|unique:employees,email,' . $id,
            'password' => 'nullable|min:6', // Cho phép rỗng (nếu không đổi pass)
            'vai_tro'  => 'required'
        ]);

        $data = [
            'ma_nv'   => $request->ma_nv,
            'ho_ten'  => $request->ho_ten,
            'email'   => $request->email,
            'vai_tro' => $request->vai_tro,
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