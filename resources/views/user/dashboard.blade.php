@extends('layouts.user')

@section('title', 'Tổng quan')

@section('content')
<!-- Khối Banner & Tìm kiếm -->
<!-- Khối Banner & Tìm kiếm (Mô phỏng) -->
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

<!-- Khối Lưới Icon Chức năng (Grid 5 cột) -->
<div class="row row-cols-2 row-cols-md-3 row-cols-lg-5 g-4 px-2">
    <!-- Item 1 -->
    <div class="col">
        <a href="{{ route('order.create') }}"
            class="card h-100 border-0 shadow-sm text-center text-decoration-none feature-card py-4 rounded-4">
            <div class="icon-wrapper bg-primary-subtle text-primary mx-auto mb-3">
                <i class="bi bi-pencil-square fs-2"></i>
            </div>
            <h6 class="text-dark fw-bold font-14 mb-0">TẠO ĐƠN HÀNG</h6>
        </a>
    </div>

    <!-- Item 2 -->
    <div class="col">
        <a href="{{ route('consignment.create') }}"
            class="card h-100 border-0 shadow-sm text-center text-decoration-none feature-card py-4 rounded-4">
            <div class="icon-wrapper bg-warning-subtle text-warning mx-auto mb-3">
                <i class="bi bi-truck fs-2"></i>
            </div>
            <h6 class="text-dark fw-bold font-14 mb-0">TẠO ĐƠN KÝ GỬI</h6>
        </a>
    </div>

    <!-- Item 3 -->
    <div class="col">
        <a href="{{ route('list.order') }}"
            class="card h-100 border-0 shadow-sm text-center text-decoration-none feature-card py-4 rounded-4">
            <div class="icon-wrapper bg-info-subtle text-info mx-auto mb-3">
                <i class="bi bi-journal-text fs-2"></i>
            </div>
            <h6 class="text-dark fw-bold font-14 mb-0">QUẢN LÝ ĐƠN HÀNG</h6>
        </a>
    </div>

    <!-- Item 3 -->
    <div class="col">
        <a href="{{ route('consignment.index') }}"
            class="card h-100 border-0 shadow-sm text-center text-decoration-none feature-card py-4 rounded-4">
            <div class="icon-wrapper bg-info-subtle text-success mx-auto mb-3">
                <i class="bi bi-journal-text fs-2"></i>
            </div>
            <h6 class="text-dark fw-bold font-14 mb-0">QUẢN LÝ ĐƠN HÀNG KÝ GỬI</h6>
        </a>
    </div>

    <!-- Item 4 -->
    <div class="col">
        <a href="{{ route('package.index') }}"
            class="card h-100 border-0 shadow-sm text-center text-decoration-none feature-card py-4 rounded-4">
            <div class="icon-wrapper bg-success-subtle text-success mx-auto mb-3">
                <i class="bi bi-boxes fs-2"></i>
            </div>
            <h6 class="text-dark fw-bold font-14 mb-0">QUẢN LÝ KIỆN HÀNG</h6>
        </a>
    </div>

    <!-- Item 5 -->
    <div class="col">
        <a href="{{ route('delivery.completed') }}"
            class="card h-100 border-0 shadow-sm text-center text-decoration-none feature-card py-4 rounded-4">
            <div class="icon-wrapper bg-info-subtle text-info mx-auto mb-3">
                <i class="bi bi-truck fs-2"></i>
            </div>
            <h6 class="text-dark fw-bold font-14 mb-0">GIAO HÀNG</h6>
        </a>
    </div>


    <div class="col">
        <a href="{{ route('transaction.index') }}"
            class="card h-100 border-0 shadow-sm text-center text-decoration-none feature-card py-4 rounded-4">
            <div class="icon-wrapper bg-primary-subtle text-primary mx-auto mb-3">
                <i class="bi bi-people fs-2"></i>
            </div>
            <h6 class="text-dark fw-bold font-14 mb-0">TÀI KHOẢN KHÁCH HÀNG</h6>
        </a>
    </div>

    <div class="col">
        <a href="{{ route('complaint.index') }}"
            class="card h-100 border-0 shadow-sm text-center text-decoration-none feature-card py-4 rounded-4">
            <div class="icon-wrapper bg-danger-subtle text-danger mx-auto mb-3">
                <i class="bi bi-chat-left-dots fs-2"></i>
            </div>
            <h6 class="text-dark fw-bold font-14 mb-0">KHIẾU NẠI</h6>
        </a>
    </div>

    <div class="col">
        <a href="{{ route('profile.edit') }}"
            class="card h-100 border-0 shadow-sm text-center text-decoration-none feature-card py-4 rounded-4">
            <div class="icon-wrapper bg-success-subtle text-success mx-auto mb-3">
                <i class="bi bi-person-vcard fs-2"></i>
            </div>
            <h6 class="text-dark fw-bold font-14 mb-0">THÔNG TIN CÁ NHÂN</h6>
        </a>
    </div>

    <div class="col">
        <a href="{{ route('supplier.index') }}"
            class="card h-100 border-0 shadow-sm text-center text-decoration-none feature-card py-4 rounded-4">
            <div class="icon-wrapper bg-warning-subtle text-warning mx-auto mb-3">
                <i class="bi bi-buildings fs-2"></i>
            </div>
            <h6 class="text-dark fw-bold font-14 mb-0">NHÀ CUNG CẤP</h6>
        </a>
    </div>

    <div class="col">
        <a href="{{ route('password.edit') }}"
            class="card h-100 border-0 shadow-sm text-center text-decoration-none feature-card py-4 rounded-4">
            <div class="icon-wrapper bg-secondary-subtle text-secondary mx-auto mb-3">
                <i class="bi bi-gear fs-2"></i>
            </div>
            <h6 class="text-dark fw-bold font-14 mb-0">CÀI ĐẶT</h6>
        </a>
    </div>
    @endsection

    @section('right_sidebar')
    <!-- SIDEBAR PHẢI (Thông tin cá nhân) -->
    <aside class="right-sidebar py-5 px-3 text-center text-white d-none d-xl-block">

        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->ho_ten ?? 'User') }}&background=ffc107&color=000&size=100"
            class="rounded-circle border border-4 border-warning shadow mb-3" alt="Avatar">

        <p class="mb-2 font-14">Cấp độ VIP</p>
        <div class="progress bg-secondary mb-4 mx-auto" style="height: 6px; width: 60%;">
            <div class="progress-bar bg-warning" role="progressbar" style="width: 0%"></div>
        </div>

        <hr class="border-secondary opacity-50 mb-4">

        <p class="font-14 text-white-50 mb-1">Họ tên</p>
        <h6 class="fw-bold mb-3">{{ Auth::user()->ho_ten ?? 'Chưa cập nhật' }}</h6>

        <p class="font-14 text-white-50 mb-1">Email</p>
        <h6 class="fw-bold mb-3">{{ Auth::user()->email ?? 'Chưa cập nhật' }}</h6>

        <p class="font-14 text-white-50 mb-1">Điện thoại</p>
        <h6 class="fw-bold mb-4">{{ Auth::user()->sdt ?? 'Chưa cập nhật' }}</h6>

        <a href="{{ route('profile.edit') }}"
            class="btn btn-outline-light rounded-pill font-14 px-4 shadow-sm mb-5">Chỉnh sửa thông tin</a>

        <!-- Tranh minh họa giờ làm việc -->
        <div class="mt-4 p-3 rounded-4"
            style="background-color: rgba(0,0,0,0.15); border: 1px dashed rgba(255,255,255,0.2);">
            <i class="bi bi-clock-history fs-1 text-warning mb-2"></i>
            <h6 class="fw-bold text-warning">8h00 - 17h30</h6>
            <small class="text-light font-12">Hỗ trợ hàng ngày</small>
        </div>

    </aside>


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
                                data-name="{{ $rateItem->currency_name }}"
                                {{ $rateItem->is_default ? 'selected' : '' }}>
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
                        <i class="bi bi-info-circle me-1"></i> Tỷ giá trên được áp dụng để tính phí mua hàng và vận
                        chuyển hộ tại hệ thống HTKK 360.
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