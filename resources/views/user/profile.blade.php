@extends('layouts.user')

@section('title', 'Tổng quan')

@section('content')

<div
    class="top-banner mb-4 p-4 rounded-4 shadow-sm bg-white d-flex flex-wrap align-items-center justify-content-between">
    <!-- Hotline -->
    <div class="d-flex align-items-center me-3 mb-3 mb-md-0">
        <i class="bi bi-headset text-primary fs-1 me-2"></i>
        <div>
            <small class="text-muted fw-bold">HOTLINE</small>
            <h5 class="text-danger fw-bold mb-0">{{ $globalSetting->hotline ?? 'Đang cập nhật...' }}</h5>
        </div>
    </div>

    <!-- Thanh tìm kiếm Taobao -->
    <div class="flex-grow-1 mx-md-4 mb-3 mb-md-0" style="max-width: 500px;">
        <div class="input-group shadow-sm rounded-pill overflow-hidden border">
            <span class="input-group-text bg-white border-0 text-danger fw-bold">Taobao</span>
            <input type="text" class="form-control border-0 shadow-none font-14"
                placeholder="Nhập từ khóa tìm kiếm (Tiếng Việt)...">
            <button class="btn text-white px-4" type="button" style="background-color: #ff6a00;"><i
                    class="bi bi-search"></i></button>
        </div>
    </div>


    <div class="d-flex align-items-center cursor-pointer" style="cursor: pointer;" data-bs-toggle="modal"
        data-bs-target="#wiseCurrencyModal" title="Nhấn để mở công cụ quy đổi tiền tệ">
        <div class="me-2 text-warning">
            <i class="bi bi-cash-coin" style="font-size: 2.2rem;"></i>
        </div>
        <div>
            <div class="text-muted fw-bold" style="font-size: 12px;">
                TỈ GIÁ ({{ $defaultExchangeRate->currency_code ?? 'CNY' }}) <i
                    class="bi bi-caret-down-fill text-dark"></i>
            </div>
            <div class="text-danger fw-bold" style="font-size: 18px;">
                {{ isset($defaultExchangeRate) ? number_format($defaultExchangeRate->rate, 0, ',', '.') : '3,520' }} đ
            </div>
        </div>
    </div>

</div>



<div class="container-fluid mt-4 px-4 pb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="text-uppercase fw-bold m-0 text-primary">
            <i class="bi bi-person-badge me-2"></i> Thông tin cá nhân
        </h3>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger shadow-sm border-0">
        <ul class="mb-0">
            @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
        </ul>
    </div>
    @endif

    <div class="row">
        <!-- Cột Trái: Thẻ thông tin tài khoản (Chỉ đọc) -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0 bg-primary text-white h-100 rounded-3">
                <div class="card-body text-center p-4">
                    <div class="mb-3">
                        <i class="bi bi-person-circle" style="font-size: 5rem;"></i>
                    </div>
                    <h4 class="fw-bold mb-1">{{ $user->ho_ten }}</h4>
                    <p class="text-white-50 mb-4">{{ $user->email }}</p>

                    <div class="bg-white text-dark rounded-3 p-3 text-start shadow-sm">
                        <div class="mb-2 d-flex justify-content-between">
                            <span class="text-muted font-13">Mã tài khoản:</span>
                            <span class="fw-bold text-primary">{{ $user->ma_tai_khoan ?? 'Chưa cấp' }}</span>
                        </div>
                        <div class="mb-0 d-flex justify-content-between align-items-center">
                            <span class="text-muted font-13">Số dư khả dụng:</span>
                            <span class="fw-bold text-danger fs-5">{{ number_format($user->so_du, 0, ',', '.') }}
                                đ</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cột Phải: Form cập nhật thông tin -->
        <div class="col-md-8 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white border-bottom pt-3 pb-2">
                    <h5 class="fw-bold text-dark"><i class="bi bi-pencil-square me-2 text-primary"></i> Cập nhật hồ sơ
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Họ và tên <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="ho_ten" class="form-control"
                                    value="{{ old('ho_ten', $user->ho_ten) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Số điện thoại</label>
                                <input type="text" name="sdt" class="form-control" value="{{ old('sdt', $user->sdt) }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Ngày sinh</label>
                                <input type="date" name="ngay_sinh" class="form-control"
                                    value="{{ old('ngay_sinh', $user->ngay_sinh ? $user->ngay_sinh->format('Y-m-d') : '') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Giới tính</label>
                                <select name="gioi_tinh" class="form-select">
                                    <option value="">-- Chọn giới tính --</option>
                                    <option value="nam"
                                        {{ old('gioi_tinh', $user->gioi_tinh) == 'nam' ? 'selected' : '' }}>Nam</option>
                                    <option value="nu"
                                        {{ old('gioi_tinh', $user->gioi_tinh) == 'nu' ? 'selected' : '' }}>Nữ</option>
                                    <option value="khac"
                                        {{ old('gioi_tinh', $user->gioi_tinh) == 'khac' ? 'selected' : '' }}>Khác
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Tỉnh / Thành phố</label>
                                <input type="text" name="tinh_thanh" class="form-control"
                                    value="{{ old('tinh_thanh', $user->tinh_thanh) }}" placeholder="VD: Hà Nội, TP.HCM">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Địa chỉ chi tiết</label>
                                <input type="text" name="dia_chi" class="form-control"
                                    value="{{ old('dia_chi', $user->dia_chi) }}"
                                    placeholder="Số nhà, đường, phường/xã...">
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">Loại vận chuyển mặc định (Gợi ý cho đơn hàng
                                    sau)</label>
                                <select name="loai_van_chuyen_mac_dinh" class="form-select border-primary">
                                    <option value="">-- Chọn phương thức mặc định --</option>
                                    <option value="thuong"
                                        {{ old('loai_van_chuyen_mac_dinh', $user->loai_van_chuyen_mac_dinh) == 'thuong' ? 'selected' : '' }}>
                                        Vận chuyển Thường (Tiết kiệm)</option>
                                    <option value="nhanh"
                                        {{ old('loai_van_chuyen_mac_dinh', $user->loai_van_chuyen_mac_dinh) == 'nhanh' ? 'selected' : '' }}>
                                        Vận chuyển Nhanh</option>
                                </select>
                            </div>

                            <div class="col-12 mt-4 text-end">
                                <button type="submit" class="btn btn-primary fw-bold px-5 shadow-sm">
                                    <i class="bi bi-save me-1"></i> Lưu Thay Đổi
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Script xử lý thêm/xóa dòng liên hệ -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const btnAddContact = document.getElementById('btnAddContact');
    const contactTableBody = document.getElementById('contactTableBody');
    let contactIndex = 1; // Bắt đầu từ 1 vì 0 đã dùng ở dòng mặc định

    // Thêm dòng mới
    btnAddContact.addEventListener('click', function() {
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
                <td class="p-1">
                    <select name="contacts[${contactIndex}][loai]" class="form-select form-select-sm border-secondary">
                        <option value="wechat">WeChat</option>
                        <option value="sdt">Số điện thoại</option>
                        <option value="qq">QQ</option>
                        <option value="email">Email</option>
                    </select>
                </td>
                <td class="p-1">
                    <input type="text" name="contacts[${contactIndex}][gia_tri]" class="form-control form-control-sm" placeholder="Nhập thông tin..." required>
                </td>
                <td class="text-center p-1">
                    <button type="button" class="btn btn-sm btn-outline-danger btn-delete-contact"><i class="bi bi-trash"></i></button>
                </td>
            `;
        contactTableBody.appendChild(newRow);
        contactIndex++;
    });

    // Xóa dòng
    contactTableBody.addEventListener('click', function(e) {
        const deleteBtn = e.target.closest('.btn-delete-contact');
        if (deleteBtn) {
            deleteBtn.closest('tr').remove();
        }
    });
});
</script>

<!-- MODAL CÔNG CỤ ĐỔI TỶ GIÁ PHONG CÁCH WISE.COM -->
<div class="modal fade" id="wiseCurrencyModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pb-0 pt-4 px-4">
                <h5 class="modal-title fw-bold" style="color: #0b3a68;">
                    <i class="bi bi-currency-exchange me-2"></i>Công cụ quy đổi tỷ giá HTKK
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-4">
                <!-- Ô 1: Số tiền ngoại tệ cần đổi -->
                <label class="form-label text-muted fw-semibold font-14">Số tiền ngoại tệ</label>
                <div class="input-group input-group-lg border rounded-3 overflow-hidden shadow-sm mb-2">
                    <input type="number" id="wiseAmountInput" class="form-control border-0 fw-bold fs-4" value="100"
                        min="0" step="any">

                    <!-- Dropdown chọn Quốc Gia / Tiền tệ -->
                    <select id="wiseCurrencySelect" class="form-select border-0 bg-light fw-bold text-dark"
                        style="max-width: 140px; cursor: pointer;">
                        @if(isset($globalExchangeRates) && count($globalExchangeRates) > 0)
                        @foreach($globalExchangeRates as $rateItem)
                        <option value="{{ $rateItem->rate }}" data-code="{{ $rateItem->currency_code }}"
                            data-name="{{ $rateItem->currency_name }}" {{ $rateItem->is_default ? 'selected' : '' }}>
                            {{ $rateItem->currency_code }} ({{$rateItem->currency_name }})
                        </option>
                        @endforeach
                        @else
                        <option value="3520" data-code="CNY" data-name="Nhân dân tệ">CNY (Tệ)</option>
                        @endif
                    </select>
                </div>

                <!-- Đường timeline hiển thị tỷ giá kiểu Wise -->
                <div class="position-relative my-3 ps-4 py-2"
                    style="border-left: 2px solid #dee2e6; margin-left: 15px;">
                    <span
                        class="position-absolute top-50 start-0 translate-middle bg-white border rounded-circle d-flex align-items-center justify-content-center"
                        style="width: 24px; height: 24px;">
                        <i class="bi bi-arrow-down-up text-primary" style="font-size: 12px;"></i>
                    </span>
                    <div class="font-14 text-muted">
                        Tỷ giá áp dụng: <strong class="text-dark" id="wiseRateDisplay">1 CNY = 3,520 VNĐ</strong>
                    </div>
                </div>

                <!-- Ô 2: Thành tiền VNĐ -->
                <label class="form-label text-muted fw-semibold font-14">Thành tiền Việt Nam (VNĐ)</label>
                <div class="input-group input-group-lg border rounded-3 overflow-hidden bg-light shadow-sm">
                    <input type="text" id="wiseResultOutput"
                        class="form-control border-0 bg-light fw-bold fs-4 text-danger" readonly>
                    <span class="input-group-text border-0 bg-light fw-bold text-dark px-4">
                        🇻🇳 VNĐ
                    </span>
                </div>

                <div class="mt-3 text-muted" style="font-size: 12px;">
                    <i class="bi bi-info-circle me-1"></i> Tỷ giá trên được áp dụng để tính phí mua hàng và vận chuyển
                    hộ tại hệ thống HTKK 360.
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SCRIPT TÍNH TOÁN THỜI GIAN THỰC -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    const amountInput = document.getElementById('wiseAmountInput');
    const currencySelect = document.getElementById('wiseCurrencySelect');
    const rateDisplay = document.getElementById('wiseRateDisplay');
    const resultOutput = document.getElementById('wiseResultOutput');

    function calculateWiseExchange() {
        if (!amountInput || !currencySelect) return;

        const amount = parseFloat(amountInput.value) || 0;
        const selectedOption = currencySelect.options[currencySelect.selectedIndex];
        const rate = parseFloat(selectedOption.value) || 0;
        const code = selectedOption.getAttribute('data-code') || '';

        // Tính tổng tiền VNĐ
        const totalVND = amount * rate;

        // Định dạng số đẹp mắt (VD: 352,000)
        const formattedRate = new Intl.NumberFormat('vi-VN').format(rate);
        const formattedTotal = new Intl.NumberFormat('vi-VN').format(Math.round(totalVND));

        // Cập nhật giao diện
        rateDisplay.innerHTML = `1 ${code} = <span class="text-danger">${formattedRate} VNĐ</span>`;
        resultOutput.value = formattedTotal;
    }

    // Lắng nghe sự kiện khi gõ phím hoặc đổi quốc gia
    if (amountInput && currencySelect) {
        amountInput.addEventListener('input', calculateWiseExchange);
        currencySelect.addEventListener('change', calculateWiseExchange);

        // Chạy lần đầu khi tải trang
        calculateWiseExchange();
    }
});
</script>

@endsection