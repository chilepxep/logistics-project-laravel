@extends('layouts.admin')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-dark text-white fw-bold">
        CẤU HÌNH THÔNG TIN CÔNG TY
    </div>
    <div class="card-body p-4">


        <form action="{{ route('admin.settings.update') }}" method="POST">
            @csrf
            @method('PUT')

            <h5 class="text-primary fw-bold mb-3 border-bottom pb-2">1. Thông tin liên hệ cơ bản</h5>
            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Hotline</label>
                    <input type="text" name="hotline" class="form-control"
                        value="{{ old('hotline', $setting->hotline) }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $setting->email) }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Link Facebook</label>
                    <input type="url" name="facebook_link" class="form-control"
                        value="{{ old('facebook_link', $setting->facebook_link) }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Link Zalo</label>
                    <input type="url" name="zalo_link" class="form-control"
                        value="{{ old('zalo_link', $setting->zalo_link) }}">
                </div>
            </div>

            <h5 class="text-primary fw-bold mb-3 border-bottom pb-2 d-flex justify-content-between align-items-center">
                <span>2. Danh sách cơ sở / Địa chỉ</span>
                <button type="button" class="btn btn-sm btn-success" onclick="addAddressField()">
                    <i class="bi bi-plus-circle"></i> Thêm cơ sở mới
                </button>
            </h5>

            <div id="address-container">

                @if(is_array($setting->addresses) && count($setting->addresses) > 0)
                @foreach($setting->addresses as $index =>$address)
                <div class="input-group mb-3 address-row">
                    <span class="input-group-text bg-light text-dark fw-bold">Cơ sở</span>
                    <input type="text" name="addresses[]" class="form-control" value="{{ $address }}">
                    <button type="button" class="btn btn-danger"
                        onclick="this.closest('.address-row').remove()">Xóa</button>
                </div>
                @endforeach
                @else

                <div class="input-group mb-3 address-row">
                    <span class="input-group-text bg-light text-dark fw-bold">Cơ sở</span>
                    <input type="text" name="addresses[]" class="form-control"
                        placeholder="Ví dụ: Kho Hà Nội: Số 123 Đường ABC...">
                    <button type="button" class="btn btn-danger"
                        onclick="this.closest('.address-row').remove()">Xóa</button>
                </div>
                @endif
            </div>

            <hr>
            <button type="submit" class="btn btn-primary px-5 py-2 fw-bold"><i class="bi bi-save"></i> LƯU THAY
                ĐỔI</button>
        </form>
    </div>
</div>

<script>
function addAddressField() {
    const container = document.getElementById('address-container');
    const html = `
            <div class="input-group mb-3 address-row">
                <span class="input-group-text bg-light text-dark fw-bold">Cơ sở</span>
                <input type="text" name="addresses[]" class="form-control" placeholder="Nhập địa chỉ cơ sở mới..." required>
                <button type="button" class="btn btn-danger" onclick="this.closest('.address-row').remove()">Xóa</button>
            </div>
        `;
    container.insertAdjacentHTML('beforeend', html);
}
</script>
@endsection