@extends('layouts.admin')
@section('title', 'Cập nhật Kiện Hàng')
@section('page_title', 'Cập nhật Kiện: ' . $package->ma_don_kien_hang)

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-body p-4">
        <form action="{{ route('admin.packages.update', $package->id) }}" method="POST">
            @csrf
            @method('PUT')

            <h6 class="fw-bold text-primary mb-3">1. Cập nhật Hành trình</h6>
            <div class="row g-3 mb-4 bg-light p-3 rounded">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Vị trí kho hiện tại</label>
                    <select name="tru_so_id" class="form-select border-primary" required>
                        @foreach($warehouses as $kho)
                        <option value="{{ $kho->id }}" {{ $package->tru_so_id == $kho->id ? 'selected' : '' }}>
                            {{ $kho->ten_kho }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Trạng thái kiện hàng</label>
                    <select name="tinh_trang" class="form-select border-primary" required>
                        <option value="cho_xu_ly" {{ $package->tinh_trang == 'cho_xu_ly' ? 'selected' : '' }}>Chờ xử lý
                        </option>
                        <option value="da_dat_hang" {{ $package->tinh_trang == 'da_dat_hang' ? 'selected' : '' }}>Đã đặt
                            hàng</option>
                        <option value="da_nhap_kho" {{ $package->tinh_trang == 'da_nhap_kho' ? 'selected' : '' }}>Đã
                            nhập kho</option>
                        <option value="dang_van_chuyen"
                            {{ $package->tinh_trang == 'dang_van_chuyen' ? 'selected' : '' }}>Đang luân chuyển</option>
                        <option value="dang_giao_hang" {{ $package->tinh_trang == 'dang_giao_hang' ? 'selected' : '' }}>
                            Đang giao hàng</option>
                        <option value="hoan_thanh" {{ $package->tinh_trang == 'hoan_thanh' ? 'selected' : '' }}>Hoàn
                            thành</option>
                        <option value="cho_cod" {{ $package->tinh_trang == 'cho_cod' ? 'selected' : '' }}>Chờ thu COD
                        </option>
                    </select>
                </div>
            </div>

            <h6 class="fw-bold text-primary mb-3">2. Thông số Kiện hàng</h6>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Mã vận đơn (TQ) <span class="text-danger">*</span></label>
                    <input type="text" name="ma_van_don" class="form-control fw-bold" value="{{ $package->ma_van_don }}"
                        required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Trọng lượng (KG)</label>
                    <input type="number" step="0.01" name="tong_kg" class="form-control text-danger fw-bold"
                        value="{{ $package->tong_kg }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Thể tích (M3)</label>
                    <input type="number" step="0.001" name="tong_m3" class="form-control text-primary fw-bold"
                        value="{{ $package->tong_m3 }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Loại hàng hoá</label>
                    <input type="text" name="loai_hang" class="form-control" value="{{ $package->loai_hang }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Ghi chú kho</label>
                    <input type="text" name="ghi_chu" class="form-control" value="{{ $package->ghi_chu }}">
                </div>
            </div>

            <h6 class="fw-bold text-primary mt-4 mb-3">3. Phí dịch vụ (VNĐ)</h6>
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label fw-bold">Phí nội địa TQ</label>
                    <input type="number" name="phi_van_chuyen_noi_dia" class="form-control"
                        value="{{ $package->phi_van_chuyen_noi_dia }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Phí khác (Đóng gỗ, vv)</label>
                    <input type="number" name="phi_khac" class="form-control" value="{{ $package->phi_khac }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Chiết khấu</label>
                    <input type="number" name="chiet_khau" class="form-control" value="{{ $package->chiet_khau }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold text-danger">Thành tiền Cước VC</label>
                    <input type="number" name="thanh_tien" class="form-control text-danger fw-bold"
                        value="{{ $package->thanh_tien }}">
                </div>
            </div>

            <hr class="my-4">
            <button type="submit" class="btn btn-primary px-5 fw-bold"><i class="bi bi-save me-2"></i> LƯU CẬP
                NHẬT</button>
            <a href="{{ route('admin.packages.index') }}" class="btn btn-light ms-2">Hủy bỏ</a>
        </form>
    </div>
</div>
@endsection