@extends('layouts.admin')
@section('title', 'Sửa Nhân Viên')
@section('page_title', 'Cập nhật tài khoản: ' . $employee->ho_ten)

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-body p-4">
        <form action="{{ route('admin.employees.update', $employee->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row g-4">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Mã nhân viên <span class="text-danger">*</span></label>
                    <input type="text" name="ma_nv" class="form-control" value="{{ $employee->ma_nv }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Họ và tên <span class="text-danger">*</span></label>
                    <input type="text" name="ho_ten" class="form-control" value="{{ $employee->ho_ten }}" required>
                </div>

                <div class="col-md-12">
                    <label class="form-label fw-bold">Email đăng nhập <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control" value="{{ $employee->email }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold text-danger">Đổi mật khẩu mới (Tuỳ chọn)</label>
                    <input type="password" name="password" class="form-control"
                        placeholder="Bỏ trống nếu không muốn đổi mật khẩu">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Phân quyền (Vai trò) <span class="text-danger">*</span></label>
                    <select name="vai_tro" class="form-select" required>
                        <option value="nhan_vien" {{ $employee->vai_tro == 'nhan_vien' ? 'selected' : '' }}>Nhân viên
                            thường</option>
                        <option value="admin" {{ $employee->vai_tro == 'admin' ? 'selected' : '' }}>Quản trị viên
                            (Admin)</option>
                    </select>
                </div>
            </div>

            <hr class="my-4">
            <button type="submit" class="btn btn-primary px-5 fw-bold"><i class="bi bi-save me-2"></i> LƯU CẬP
                NHẬT</button>
            <a href="{{ route('admin.employees.index') }}" class="btn btn-light ms-2">Hủy bỏ</a>
        </form>
    </div>
</div>
@endsection