@extends('layouts.admin')
@section('title', 'Sửa Nhà Cung Cấp')
@section('page_title', 'Cập nhật NCC: ' . $supplier->ten_ncc)

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-body p-4">
        <form action="{{ route('admin.suppliers.update', $supplier->id) }}" method="POST">
            @csrf
            @method('PUT')

            <h6 class="fw-bold text-primary mb-3">1. Thông tin Cơ bản & Vị trí</h6>
            <div class="row g-3 mb-4 bg-light p-3 rounded">
                <div class="col-md-3">
                    <label class="form-label fw-bold">Mã NCC <span class="text-danger">*</span></label>
                    <input type="text" name="ma_ncc" class="form-control" required value="{{ $supplier->ma_ncc }}">
                </div>
                <div class="col-md-5">
                    <label class="form-label fw-bold">Tên Nhà cung cấp <span class="text-danger">*</span></label>
                    <input type="text" name="ten_ncc" class="form-control" required value="{{ $supplier->ten_ncc }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Hình thức <span class="text-danger">*</span></label>
                    <select name="hinh_thuc" class="form-select" required>
                        <option value="online" {{ $supplier->hinh_thuc == 'online' ? 'selected' : '' }}>Online (Taobao,
                            Amazon...)</option>
                        <option value="offline" {{ $supplier->hinh_thuc == 'offline' ? 'selected' : '' }}>Offline
                            (Xưởng, Chợ...)</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Quốc gia <span class="text-danger">*</span></label>
                    <select name="country_id" class="form-select" required>
                        <option value="">-- Chọn Quốc gia --</option>
                        @foreach($countries as $country)
                        <option value="{{ $country->id }}"
                            {{ $supplier->country_id == $country->id ? 'selected' : '' }}>
                            {{ $country->ten_quoc_gia }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Thành phố / Tỉnh bang</label>
                    <input type="text" name="thanh_pho" class="form-control" value="{{ $supplier->thanh_pho }}">
                </div>
                <div class="col-md-12">
                    <label class="form-label fw-bold">Ngành hàng</label>
                    <input type="text" name="nganh_hang" class="form-control" value="{{ $supplier->nganh_hang }}">
                </div>
            </div>

            <h6 class="fw-bold text-primary mb-3">2. Thông tin Tài khoản Ngân hàng</h6>
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <label class="form-label fw-bold">Tên Ngân hàng</label>
                    <input type="text" name="ten_ngan_hang" class="form-control" value="{{ $supplier->ten_ngan_hang }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Số tài khoản</label>
                    <input type="text" name="so_tai_khoan" class="form-control" value="{{ $supplier->so_tai_khoan }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Chủ tài khoản</label>
                    <input type="text" name="chu_tai_khoan" class="form-control" value="{{ $supplier->chu_tai_khoan }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Chi nhánh</label>
                    <input type="text" name="chi_nhanh" class="form-control" value="{{ $supplier->chi_nhanh }}">
                </div>
            </div>

            <h6 class="fw-bold text-primary mb-3 d-flex justify-content-between align-items-center">
                <span>3. Danh bạ Liên hệ (Phone, Wechat, Line...)</span>
                <button type="button" class="btn btn-sm btn-success" id="addContactBtn"><i class="bi bi-plus"></i> Thêm
                    liên hệ</button>
            </h6>
            <div id="contactWrapper" class="mb-4">

                @if($supplier->contacts->count() > 0)
                @foreach($supplier->contacts as $index => $contact)
                <div class="row g-2 mb-2 contact-row">
                    <div class="col-md-3">
                        <select name="contacts[{{ $index }}][loai]" class="form-select">
                            <option value="sdt" {{ $contact->loai == 'sdt' ? 'selected' : '' }}>Số điện thoại</option>
                            <option value="wechat" {{ $contact->loai == 'wechat' ? 'selected' : '' }}>WeChat</option>
                            <option value="line" {{ $contact->loai == 'line' ? 'selected' : '' }}>Line</option>
                            <option value="whatsapp" {{ $contact->loai == 'whatsapp' ? 'selected' : '' }}>WhatsApp
                            </option>
                            <option value="telegram" {{ $contact->loai == 'telegram' ? 'selected' : '' }}>Telegram
                            </option>
                            <option value="email" {{ $contact->loai == 'email' ? 'selected' : '' }}>Email</option>
                        </select>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="contacts[{{ $index }}][gia_tri]" class="form-control"
                            value="{{ $contact->gia_tri }}">
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-danger w-100 remove-contact"><i
                                class="bi bi-trash"></i></button>
                    </div>
                </div>
                @endforeach
                @else
                <!-- Hiện 1 dòng trống nếu cũ ko có gì -->
                <div class="row g-2 mb-2 contact-row">
                    <div class="col-md-3">
                        <select name="contacts[0][loai]" class="form-select">
                            <option value="sdt">Số điện thoại</option>
                            <option value="wechat">WeChat</option>
                            <option value="line">Line</option>
                            <option value="whatsapp">WhatsApp</option>
                        </select>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="contacts[0][gia_tri]" class="form-control">
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-danger w-100 remove-contact" disabled><i
                                class="bi bi-trash"></i></button>
                    </div>
                </div>
                @endif

            </div>

            <hr class="my-4">
            <button type="submit" class="btn btn-primary px-5 fw-bold"><i class="bi bi-save me-2"></i> LƯU CẬP
                NHẬT</button>
            <a href="{{ route('admin.suppliers.index') }}" class="btn btn-light ms-2">Hủy bỏ</a>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let contactIndex = parseInt("{{ max(1, $supplier->contacts->count()) }}");

    const wrapper = document.getElementById('contactWrapper');

    document.getElementById('addContactBtn').addEventListener('click', function() {
        const html = `
        <div class="row g-2 mb-2 contact-row">
            <div class="col-md-3">
                <select name="contacts[${contactIndex}][loai]" class="form-select">
                    <option value="sdt">Số điện thoại</option>
                    <option value="wechat">WeChat</option>
                    <option value="line">Line</option>
                    <option value="whatsapp">WhatsApp</option>
                    <option value="telegram">Telegram</option>
                    <option value="email">Email</option>
                </select>
            </div>
            <div class="col-md-8">
                <input type="text" name="contacts[${contactIndex}][gia_tri]" class="form-control" placeholder="Nhập số điện thoại / ID / Email...">
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-danger w-100 remove-contact"><i class="bi bi-trash"></i></button>
            </div>
        </div>`;
        wrapper.insertAdjacentHTML('beforeend', html);
        contactIndex++;
    });

    wrapper.addEventListener('click', function(e) {
        if (e.target.closest('.remove-contact')) {
            e.target.closest('.contact-row').remove();
        }
    });
});
</script>
@endsection