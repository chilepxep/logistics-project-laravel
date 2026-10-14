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
        <h3 class="text-uppercase fw-bold m-0" style="color: #6f42c1;">
            <i class="bi bi-shop-window me-2"></i> Thêm Nhà Cung Cấp
        </h3>
        <a href="{{ route('supplier.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Quay lại
        </a>
    </div>

    @if($errors->any())
    <div class="alert alert-danger mb-4">
        <ul class="mb-0">
            @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('supplier.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <!-- CỘT TRÁI: THÔNG TIN CHUNG -->
            <div class="col-md-7 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header text-white fw-bold text-uppercase" style="background-color: #6f42c1;">
                        1. Thông tin cơ bản
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Mã NCC <span class="text-danger">*</span></label>
                                <input type="text" name="ma_ncc" class="form-control text-uppercase"
                                    value="{{ old('ma_ncc', $suggestedCode) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Tên Nhà Cung Cấp <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="ten_ncc" class="form-control" placeholder="VD: Quảng Châu Shop"
                                    value="{{ old('ten_ncc') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Hình thức <span
                                        class="text-danger">*</span></label>
                                <select name="hinh_thuc" class="form-select" required>
                                    <option value="online" {{ old('hinh_thuc') == 'online' ? 'selected' : '' }}>Trực
                                        tuyến (Taobao, 1688...)</option>
                                    <option value="offline" {{ old('hinh_thuc') == 'offline' ? 'selected' : '' }}>Trực
                                        tiếp (Xưởng, Chợ...)</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Ngành hàng</label>
                                <input type="text" name="nganh_hang" class="form-control"
                                    placeholder="VD: Quần áo, Điện tử..." value="{{ old('nganh_hang') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Người đại diện</label>
                                <input type="text" name="ten_nguoi_dai_dien" class="form-control"
                                    value="{{ old('ten_nguoi_dai_dien') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Chức vụ</label>
                                <input type="text" name="chuc_vu" class="form-control"
                                    placeholder="VD: Quản lý, Sales..." value="{{ old('chuc_vu') }}">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Upload Logo (Nếu có)</label>
                                <input type="file" name="logo_file" class="form-control" accept="image/*">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Mô tả / Ghi chú thêm</label>
                                <textarea name="chi_tiet" class="form-control" rows="2">{{ old('chi_tiet') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CỘT PHẢI: NGÂN HÀNG & LIÊN HỆ -->
            <div class="col-md-5 mb-4">

                <!-- Bảng Tài Khoản Ngân Hàng -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header text-white fw-bold text-uppercase" style="background-color: #6f42c1;">
                        2. Tài khoản thanh toán
                    </div>
                    <div class="card-body p-3">
                        <div class="mb-2">
                            <label class="form-label font-13 fw-semibold">Tên Ngân Hàng (TQ/VN)</label>
                            <input type="text" name="ten_ngan_hang" class="form-control form-control-sm"
                                value="{{ old('ten_ngan_hang') }}">
                        </div>
                        <div class="mb-2">
                            <label class="form-label font-13 fw-semibold">Số Tài Khoản</label>
                            <input type="text" name="so_tai_khoan"
                                class="form-control form-control-sm text-primary fw-bold"
                                value="{{ old('so_tai_khoan') }}">
                        </div>
                        <div class="mb-2">
                            <label class="form-label font-13 fw-semibold">Tên Chủ Tài Khoản</label>
                            <input type="text" name="chu_tai_khoan" class="form-control form-control-sm text-uppercase"
                                value="{{ old('chu_tai_khoan') }}">
                        </div>
                        <div class="mb-0">
                            <label class="form-label font-13 fw-semibold">Chi nhánh</label>
                            <input type="text" name="chi_nhanh" class="form-control form-control-sm"
                                value="{{ old('chi_nhanh') }}">
                        </div>
                    </div>
                </div>

                <!-- Bảng Liên hệ Động (Dynamic Fields) -->
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-light fw-bold text-uppercase d-flex justify-content-between align-items-center"
                        style="color: #6f42c1;">
                        <span>3. Phương thức liên hệ</span>
                        <button type="button" id="btnAddContact" class="btn btn-sm text-white"
                            style="background-color: #6f42c1;">
                            <i class="bi bi-plus"></i> Thêm dòng
                        </button>
                    </div>
                    <div class="card-body p-2">
                        <table class="table table-borderless mb-0 align-middle">
                            <tbody id="contactTableBody">
                                <!-- Một dòng liên hệ mặc định -->
                                <tr>
                                    <td style="width: 40%;" class="p-1">
                                        <select name="contacts[0][loai]"
                                            class="form-select form-select-sm border-secondary">
                                            <option value="sdt">Số điện thoại</option>
                                            <option value="wechat">WeChat</option>
                                            <option value="qq">QQ</option>
                                            <option value="email">Email</option>
                                        </select>
                                    </td>
                                    <td style="width: 50%;" class="p-1">
                                        <input type="text" name="contacts[0][gia_tri]"
                                            class="form-control form-control-sm" placeholder="Nhập thông tin..."
                                            required>
                                    </td>
                                    <td style="width: 10%;" class="text-center p-1">
                                        <button type="button"
                                            class="btn btn-sm btn-outline-danger btn-delete-contact"><i
                                                class="bi bi-trash"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <!-- NÚT LƯU -->
            <div class="col-12 text-center mt-2">
                <hr>
                <button type="submit" class="btn btn-lg text-white fw-bold px-5 shadow-sm"
                    style="background-color: #6f42c1;">
                    <i class="bi bi-save me-2"></i> LƯU NHÀ CUNG CẤP
                </button>
            </div>
        </div>
    </form>
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