@extends('layouts.admin')
@section('title', 'Thêm Nhân Viên')
@section('page_title', 'Thêm Nhân viên mới')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-body p-4">
        <form action="{{ route('admin.employees.store') }}" method="POST">
            @csrf

            <div class="row g-4">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Mã nhân viên <span class="text-danger">*</span></label>
                    <input type="text" name="ma_nv" class="form-control" value="{{ old('ma_nv') }}"
                        placeholder="VD: NV001" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Họ và tên <span class="text-danger">*</span></label>
                    <input type="text" name="ho_ten" class="form-control" value="{{ old('ho_ten') }}" required>
                </div>

                <div class="col-md-12">
                    <label class="form-label fw-bold">Email đăng nhập <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Mật khẩu <span class="text-danger">*</span></label>
                    <input type="password" name="password" class="form-control" placeholder="Tối thiểu 6 ký tự" required
                        minlength="6">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Phân quyền (Vai trò) <span class="text-danger">*</span></label>
                    <select name="vai_tro" class="form-select" required>
                        <option value="nhan_vien" {{ old('vai_tro') == 'nhan_vien' ? 'selected' : '' }}>Nhân viên thường
                        </option>
                        <option value="admin" {{ old('vai_tro') == 'admin' ? 'selected' : '' }}>Quản trị viên (Admin)
                        </option>
                    </select>
                </div>

                <!-- BỘ LỌC QUỐC GIA & KHO LÀM VIỆC -->
                <div class="col-md-4">
                    <label class="form-label fw-bold text-primary">Khu vực / Quốc gia</label>
                    <select id="countrySelect" class="form-select border-primary">
                        <option value="">-- Tất cả quốc gia --</option>
                        <option value="VN">Việt Nam (VN)</option>
                        <option value="TQ">Trung Quốc (TQ)</option>
                        <option value="JP">Nhật Bản (JP)</option>
                        <option value="AU">Úc (AU)</option>
                        <option value="DE">Đức (DE)</option>
                        <option value="FR">Pháp (FR)</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-bold text-primary">Kho làm việc (Trụ sở)</label>
                    <select name="warehouse_id" id="warehouseSelect" class="form-select border-primary">
                        <option value="">-- Chọn kho --</option>
                        @foreach($warehouses as $kho)
                        <option value="{{ $kho->id }}" data-country="{{ $kho->loai_kho }}"
                            {{ old('warehouse_id') == $kho->id ? 'selected' : '' }}>
                            {{ $kho->ten_kho }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- TRẠNG THÁI HOẠT ĐỘNG (is_approved) -->
                <div class="col-md-4">
                    <label class="form-label fw-bold">Trạng thái tài khoản</label>
                    <div class="form-check form-switch mt-2">
                        <!-- Mặc định bật (1) khi tạo mới -->
                        <input class="form-check-input fs-5 shadow-none" type="checkbox" name="is_approved"
                            id="isApprovedSwitch" value="1" {{ old('is_approved', '1') ? 'checked' : '' }}>
                        <label
                            class="form-check-label pt-1 ms-2 {{ old('is_approved', '1') ? 'text-success fw-bold' : 'text-muted' }}"
                            for="isApprovedSwitch" id="statusLabel">
                            {{ old('is_approved', '1') ? 'Đang hoạt động' : 'Đang khóa' }}
                        </label>
                    </div>
                </div>
            </div>

            <hr class="my-4">
            <button type="submit" class="btn btn-primary px-5 fw-bold"><i class="bi bi-save me-2"></i> TẠO TÀI
                KHOẢN</button>
            <a href="{{ route('admin.employees.index') }}" class="btn btn-light ms-2">Hủy bỏ</a>
        </form>
    </div>
</div>

<!-- JAVASCRIPT XỬ LÝ LỌC KHO VÀ ĐỔI NHÃN TRẠNG THÁI -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    const countrySelect = document.getElementById('countrySelect');
    const warehouseSelect = document.getElementById('warehouseSelect');
    const options = Array.from(warehouseSelect.options);

    // Hàm lọc kho
    function filterWarehouses(countryCode) {
        options.forEach(option => {
            if (option.value === "") return;

            if (countryCode === "" || option.dataset.country === countryCode) {
                option.style.display = "";
            } else {
                option.style.display = "none";
                if (option.selected) {
                    warehouseSelect.value = "";
                }
            }
        });
    }

    // Tự động khôi phục Quốc gia nếu form bị lỗi validation (giữ lại old data)
    const initialSelected = warehouseSelect.options[warehouseSelect.selectedIndex];
    if (initialSelected && initialSelected.value !== "") {
        const currentCountry = initialSelected.dataset.country;
        if (currentCountry) {
            countrySelect.value = currentCountry;
            filterWarehouses(currentCountry);
        }
    }

    // Khi người dùng tự chọn Quốc gia
    countrySelect.addEventListener('change', function() {
        filterWarehouses(this.value);
    });

    // Đổi chữ Trạng thái động
    const statusSwitch = document.getElementById('isApprovedSwitch');
    const statusLabel = document.getElementById('statusLabel');
    statusSwitch.addEventListener('change', function() {
        if (this.checked) {
            statusLabel.textContent = 'Đang hoạt động';
            statusLabel.className = 'form-check-label pt-1 ms-2 text-success fw-bold';
        } else {
            statusLabel.textContent = 'Đang khóa';
            statusLabel.className = 'form-check-label pt-1 ms-2 text-muted';
        }
    });
});
</script>
@endsection