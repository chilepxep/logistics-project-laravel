@extends('layouts.admin')
@section('title', 'Quản lý Kho')
@section('page_title', 'Cập nhật kho')

@section('content')
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-dark text-white fw-bold">CẬP NHẬT KHO</div>
    <div class="card-body p-4">

        <form action="{{ route('admin.warehouses.update', $warehouse->id) }}" method="POST"
            onsubmit="let btn = this.querySelector('button[type=submit]'); btn.disabled = true; btn.innerHTML = '<i class=\'bi bi-hourglass-split\'></i> ĐANG CẬP NHẬT...';">

            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Loại kho (Quốc gia) *</label>
                    <select name="loai_kho" id="loai_kho" class="form-select" required>
                        <option value="">-- Chọn loại kho --</option>
                        <!-- Đã sửa: Bổ sung $warehouse->loai_kho để hiển thị đúng lựa chọn cũ -->
                        <option value="VN" {{ old('loai_kho', $warehouse->loai_kho) == 'VN' ? 'selected' : '' }}>Việt
                            Nam (VN)</option>
                        <option value="TQ" {{ old('loai_kho', $warehouse->loai_kho) == 'TQ' ? 'selected' : '' }}>Trung
                            Quốc (TQ)</option>
                        <option value="JP" {{ old('loai_kho', $warehouse->loai_kho) == 'JP' ? 'selected' : '' }}>Nhật
                            Bản (JP)</option>
                        <option value="AU" {{ old('loai_kho', $warehouse->loai_kho) == 'AU' ? 'selected' : '' }}>Úc (AU)
                        </option>
                        <option value="DE" {{ old('loai_kho', $warehouse->loai_kho) == 'DE' ? 'selected' : '' }}>Đức
                            (DE)</option>
                        <option value="FR" {{ old('loai_kho', $warehouse->loai_kho) == 'FR' ? 'selected' : '' }}>Pháp
                            (FR)</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Mã kho *</label>
                    <!-- Đã sửa: Thêm $warehouse->ma_kho -->
                    <input type="text" name="ma_kho" id="ma_kho" class="form-control" required
                        value="{{ old('ma_kho', $warehouse->ma_kho) }}" placeholder="VD: VN-HN1">
                    <small class="text-danger">Mã kho phải bắt đầu bằng Loại kho (VD: VN-)</small>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Tên kho *</label>
                    <!-- Đã sửa: Thêm $warehouse->ten_kho -->
                    <input type="text" name="ten_kho" class="form-control" required
                        value="{{ old('ten_kho', $warehouse->ten_kho) }}" placeholder="VD: Kho Hà Nội 1">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Địa chỉ chi tiết *</label>
                    <!-- Đã sửa: Thêm $warehouse->dia_chi -->
                    <input type="text" name="dia_chi" class="form-control" required
                        value="{{ old('dia_chi', $warehouse->dia_chi) }}" placeholder="Nhập địa chỉ kho...">
                </div>
            </div>

            <button type="submit" class="btn btn-primary px-5 fw-bold mt-3"><i class="bi bi-save"></i> CẬP NHẬT</button>
            <a href="{{ route('admin.warehouses.index') }}" class="btn btn-light px-4 border mt-3 ms-2">Hủy</a>
        </form>
    </div>
</div>

<script>
document.getElementById('loai_kho').addEventListener('change', function() {
    let prefix = this.value;
    let inputMaKho = document.getElementById('ma_kho');

    if (prefix) {

        inputMaKho.value = prefix + '-';
        inputMaKho.focus();
    } else {
        inputMaKho.value = '';
    }
});
</script>
@endsection