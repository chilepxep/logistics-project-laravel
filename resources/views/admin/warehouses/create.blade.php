@extends('layouts.admin')
@section('title', 'Quản lý Kho')
@section('page_title', 'Tạo Kho mới')

@section('content')
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-dark text-white fw-bold">THÊM KHO MỚI</div>
    <div class="card-body p-4">

        <form action="{{ route('admin.warehouses.store') }}" method="POST"
            onsubmit="let btn = this.querySelector('button[type=submit]'); btn.disabled = true; btn.innerHTML = '<i class=\'bi bi-hourglass-split\'></i> ĐANG LƯU...';">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Loại kho (Quốc gia) *</label>
                    <select name="loai_kho" id="loai_kho" class="form-select" required>
                        <option value="">-- Chọn loại kho --</option>
                        @foreach($countries as $country)
                        <option value="{{ $country->ma_quoc_gia }}"
                            {{ old('loai_kho') == $country->ma_quoc_gia ? 'selected' : '' }}>
                            {{ $country->ten_quoc_gia }} ({{ $country->ma_quoc_gia }})
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Mã kho *</label>
                    <input type="text" name="ma_kho" id="ma_kho" class="form-control" required
                        value="{{ old('ma_kho') }}" placeholder="VD: VN-HN1">
                    <small class="text-danger">Mã kho phải bắt đầu bằng Loại kho (VD: VN-)</small>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Tên kho *</label>
                    <input type="text" name="ten_kho" class="form-control" required value="{{ old('ten_kho') }}"
                        placeholder="VD: Kho Hà Nội 1">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Địa chỉ chi tiết *</label>
                    <input type="text" name="dia_chi" class="form-control" required value="{{ old('dia_chi') }}"
                        placeholder="Nhập địa chỉ kho...">
                </div>
            </div>

            <button type="submit" class="btn btn-primary px-5 fw-bold mt-3"><i class="bi bi-save"></i> LƯU KHO</button>
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