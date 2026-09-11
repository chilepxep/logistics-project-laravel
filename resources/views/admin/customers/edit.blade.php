@extends('layouts.admin')
@section('title', 'Sửa Hồ Sơ Khách Hàng')
@section('page_title', 'Sửa hồ sơ: ' . $customer->ho_ten)

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <form action="{{ route('admin.customers.update', $customer->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Mã tài khoản</label>
                            <input type="text" class="form-control bg-light" value="{{ $customer->ma_tai_khoan }}"
                                readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Họ tên <span class="text-danger">*</span></label>
                            <input type="text" name="ho_ten" class="form-control" value="{{ $customer->ho_ten }}"
                                required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" value="{{ $customer->email }}"
                                required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Số điện thoại</label>
                            <input type="text" name="sdt" class="form-control" value="{{ $customer->sdt }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Ngày sinh</label>
                            <input type="date" name="ngay_sinh" class="form-control" value="{{ $customer->ngay_sinh }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Giới tính</label>
                            <select name="gioi_tinh" class="form-select">
                                <option value="">-- Chọn --</option>
                                <option value="nam" {{ $customer->gioi_tinh == 'nam' ? 'selected' : '' }}>Nam</option>
                                <option value="nu" {{ $customer->gioi_tinh == 'nu' ? 'selected' : '' }}>Nữ</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Tỉnh/Thành phố</label>
                            <input type="text" name="tinh_thanh" class="form-control"
                                value="{{ $customer->tinh_thanh }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Loại VC mặc định</label>
                            <select name="loai_van_chuyen_mac_dinh" class="form-select">
                                <option value="thuong"
                                    {{ $customer->loai_van_chuyen_mac_dinh == 'thuong' ? 'selected' : '' }}>Thường
                                </option>
                                <option value="nhanh"
                                    {{ $customer->loai_van_chuyen_mac_dinh == 'nhanh' ? 'selected' : '' }}>Nhanh
                                </option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Địa chỉ chi tiết</label>
                            <textarea name="dia_chi" class="form-control" rows="2">{{ $customer->dia_chi }}</textarea>
                        </div>
                    </div>

                    <hr class="my-4">
                    <button type="submit" class="btn btn-primary px-5 fw-bold"><i class="bi bi-save me-2"></i> LƯU THÔNG
                        TIN</button>
                    <a href="{{ route('admin.customers.show', $customer->id) }}" class="btn btn-light ms-2">Hủy bỏ</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection