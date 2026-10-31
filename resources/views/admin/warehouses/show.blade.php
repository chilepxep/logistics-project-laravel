@extends('layouts.admin')
@section('title', 'Quản lý Kho')
@section('page_title', 'Cập nhật kho')

@section('content')
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-dark text-white fw-bold">CHI TIẾT KHO</div>
    <div class="card-body p-4">

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold text-muted">Loại kho (Quốc gia)</label>
                <select class="form-select bg-light" disabled>
                    <option value="">-- Chọn loại kho --</option>
                    @foreach($countries as $country)
                    <option value="{{ $country->ma_quoc_gia }}"
                        {{ $warehouse->loai_kho == $country->ma_quoc_gia ? 'selected' : '' }}>
                        {{ $country->ten_quoc_gia }} ({{ $country->ma_quoc_gia }})
                    </option>
                    @endforeach
                    <option value="VN" {{ $warehouse->loai_kho == 'VN' ? 'selected' : '' }}>Việt Nam (VN)</option>
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold text-muted">Mã kho</label>
                <input type="text" class="form-control bg-light" disabled value="{{ $warehouse->ma_kho }}">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold text-muted">Tên kho</label>
                <input type="text" class="form-control bg-light" disabled value="{{ $warehouse->ten_kho }}">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold text-muted">Địa chỉ chi tiết</label>
                <input type="text" class="form-control bg-light" disabled value="{{ $warehouse->dia_chi }}">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold text-muted">Số điện thoại</label>
                <input type="text" class="form-control bg-light" disabled
                    value="{{ $warehouse->so_dien_thoai ?? 'Không có' }}">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold text-muted">Mã bưu điện (Zip Code)</label>
                <input type="text" class="form-control bg-light" disabled
                    value="{{ $warehouse->ma_buu_dien ?? 'Không có' }}">
            </div>

            <div class="col-md-12 mb-3">
                <label class="form-label fw-bold text-muted">Ghi chú (Tên người quản lý, lưu ý kho...)</label>
                <textarea class="form-control bg-light" rows="3"
                    disabled>{{ $warehouse->ghi_chu ?? 'Không có ghi chú' }}</textarea>
            </div>
        </div>

        <div class="mt-4">
            <a href="{{ route('admin.warehouses.index') }}" class="btn btn-secondary px-4 fw-bold">
                <i class="bi bi-arrow-left"></i> QUAY LẠI DANH SÁCH
            </a>
        </div>

    </div>
</div>
@endsection