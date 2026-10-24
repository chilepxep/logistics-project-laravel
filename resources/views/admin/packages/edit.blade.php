@extends('layouts.admin')
@section('title', 'Cập nhật Kiện Hàng')
@section('page_title', 'Cập nhật Kiện: ' . $package->ma_don_kien_hang)

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-body p-4">

        @php
        $user = Auth::user();

        // Truy vấn lấy mảng tất cả các ID kho thuộc Việt Nam
        $danhSachKhoVN = \App\Models\Warehouse::where('loai_kho', 'VN')->pluck('id')->toArray();

        // Cấp quyền nếu là Admin HOẶC là nhân viên đang làm việc tại BẤT KỲ kho VN nào
        $canEditMetrics = ($user->vai_tro === 'admin' || ($user->vai_tro === 'nhan_vien' &&
        in_array($user->warehouse_id, $danhSachKhoVN)));

        $readonlyAttr = $canEditMetrics ? '' : 'readonly';
        $lockedClass = $canEditMetrics ? '' : 'bg-light text-muted';
        @endphp

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
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Trạng thái kiện hàng</label>
                    <select name="tinh_trang" class="form-select border-primary" required>
                        <option value="cho_xu_ly" {{ $package->tinh_trang == 'cho_xu_ly' ? 'selected' : '' }}>Chờ xử lý
                        </option>
                        <option value="da_nhap_kho" {{ $package->tinh_trang == 'da_nhap_kho' ? 'selected' : '' }}>Đã
                            nhập kho</option>
                        <option value="dang_van_chuyen"
                            {{ $package->tinh_trang == 'dang_van_chuyen' ? 'selected' : '' }}>Đang luân chuyển (Quốc tế)
                        </option>
                        <option value="dang_giao_hang" {{ $package->tinh_trang == 'dang_giao_hang' ? 'selected' : '' }}>
                            Đang giao hàng (Nội địa VN)</option>
                        <option value="hoan_thanh" {{ $package->tinh_trang == 'hoan_thanh' ? 'selected' : '' }}>Hoàn
                            thành</option>
                        <option value="tra_hang" {{ $package->tinh_trang == 'tra_hang' ? 'selected' : '' }}>Trả hàng
                        </option>
                    </select>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold text-primary mb-0">2. Thông số Kiện hàng</h6>
                @if(!$canEditMetrics)
                <span class="badge bg-warning text-dark"><i class="bi bi-lock-fill"></i> Chỉ kho VN được sửa thông
                    số</span>
                @endif
            </div>

            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Mã vận đơn (TQ) <span class="text-danger">*</span></label>
                    <input type="text" name="ma_van_don" class="form-control fw-bold" value="{{ $package->ma_van_don }}"
                        required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Trọng lượng (KG)</label>
                    <input type="number" step="0.01" name="tong_kg"
                        class="form-control fw-bold {{ $canEditMetrics ? 'text-danger' : $lockedClass }}"
                        value="{{ $package->tong_kg }}" {{ $readonlyAttr }}>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Thể tích (M3)</label>
                    <input type="number" step="0.001" name="tong_m3"
                        class="form-control fw-bold {{ $canEditMetrics ? 'text-primary' : $lockedClass }}"
                        value="{{ $package->tong_m3 }}" {{ $readonlyAttr }}>
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
                    <input type="number" name="phi_van_chuyen_noi_dia" class="form-control {{ $lockedClass }}"
                        value="{{ $package->phi_van_chuyen_noi_dia }}" {{ $readonlyAttr }}>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Phí khác (Đóng gỗ, vv)</label>
                    <input type="number" name="phi_khac" class="form-control {{ $lockedClass }}"
                        value="{{ $package->phi_khac }}" {{ $readonlyAttr }}>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Chiết khấu</label>
                    <input type="number" name="chiet_khau" class="form-control {{ $lockedClass }}"
                        value="{{ $package->chiet_khau }}" {{ $readonlyAttr }}>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold text-danger">Thành tiền Cước VC</label>
                    <input type="number" name="thanh_tien"
                        class="form-control fw-bold {{ $canEditMetrics ? 'text-danger' : $lockedClass }}"
                        value="{{ $package->thanh_tien }}" {{ $readonlyAttr }}>
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