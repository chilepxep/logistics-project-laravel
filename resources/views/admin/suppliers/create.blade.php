@extends('layouts.admin')
@section('title', 'Thêm Nhà Cung Cấp')
@section('page_title', 'Thêm Nhà cung cấp mới')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-body p-4">
        <form action="{{ route('admin.suppliers.store') }}" method="POST">
            @csrf

            <h6 class="fw-bold text-primary mb-3">1. Thông tin Cơ bản & Vị trí</h6>
            <div class="row g-3 mb-4 bg-light p-3 rounded">
                <div class="col-md-3">
                    <label class="form-label fw-bold">Mã NCC <span class="text-danger">*</span></label>
                    <input type="text" name="ma_ncc" class="form-control" required placeholder="VD: NCC_001">
                </div>
                <div class="col-md-5">
                    <label class="form-label fw-bold">Tên Nhà cung cấp <span class="text-danger">*</span></label>
                    <input type="text" name="ten_ncc" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Hình thức <span class="text-danger">*</span></label>
                    <select name="hinh_thuc" class="form-select" required>
                        <option value="online">Online (Taobao, 1688...)</option>
                        <option value="offline">Offline (Xưởng, Chợ...)</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Quốc gia <span class="text-danger">*</span></label>
                    <select name="country_id" class="form-select" required>
                        <option value="">-- Chọn Quốc gia --</option>
                        @foreach($countries as $country)
                        <option value="{{ $country->id }}">{{ $country->ten_quoc_gia }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Thành phố / Tỉnh bang</label>
                    <input type="text" name="thanh_pho" class="form-control"
                        placeholder="VD: Tokyo, Sydney, Quảng Châu...">
                </div>
                <div class="col-md-12">
                    <label class="form-label fw-bold">Ngành hàng</label>
                    <input type="text" name="nganh_hang" class="form-control" placeholder="VD: Thời trang, Điện tử...">
                </div>
            </div>

            <h6 class="fw-bold text-primary mb-3">2. Thông tin Tài khoản Ngân hàng (Để thanh toán)</h6>
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <label class="form-label fw-bold">Tên Ngân hàng</label>
                    <input type="text" name="ten_ngan_hang" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Số tài khoản</label>
                    <input type="text" name="so_tai_khoan" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Chủ tài khoản</label>
                    <input type="text" name="chu_tai_khoan" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Chi nhánh</label>
                    <input type="text" name="chi_nhanh" class="form-control">
                </div>
            </div>

            <h6 class="fw-bold text-primary mb-3 d-flex justify-content-between align-items-center">
                <span>3. Danh bạ Liên hệ (Phone, Wechat, Line...)</span>
                <button type="button" class="btn btn-sm btn-success" id="addContactBtn"><i class="bi bi-plus"></i> Thêm
                    liên hệ</button>
            </h6>
            <div id="contactWrapper" class="mb-4">
                <!-- Dòng liên hệ mẫu -->
                <div class="row g-2 mb-2 contact-row">
                    <div class="col-md-3">
                        <select name="contacts[0][loai]" class="form-select">
                            <option value="sdt">Số điện thoại</option>
                            <option value="wechat">WeChat</option>
                            <option value="line">Line (Nhật/Thái)</option>
                            <option value="whatsapp">WhatsApp</option>
                            <option value="telegram">Telegram</option>
                            <option value="email">Email</option>
                        </select>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="contacts[0][gia_tri]" class="form-control"
                            placeholder="Nhập số điện thoại / ID / Email...">
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-danger w-100 remove-contact" disabled><i
                                class="bi bi-trash"></i></button>
                    </div>
                </div>
            </div>

            <hr class="my-4">
            <button type="submit" class="btn btn-primary px-5 fw-bold"><i class="bi bi-save me-2"></i> LƯU NHÀ CUNG
                CẤP</button>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let contactIndex = 1;
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