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

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show mb-4 shadow-sm border-0" role="alert">
    <i class="bi bi-check-circle-fill me-2"></i> <strong>Thành công!</strong> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show mb-4 shadow-sm border-0" role="alert">
    <i class="bi bi-exclamation-triangle-fill me-2"></i> <strong>Lỗi!</strong>
    <ul class="mb-0 mt-1 ps-3">
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="container-fluid mt-4 px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="text-uppercase fw-bold m-0" style="color: #20c997;">
            <i class="bi bi-search me-2"></i> Yêu cầu Kiểm hàng
        </h3>
    </div>

    <!-- KHỐI BỘ LỌC TÌM KIẾM -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body p-3">
            <form action="{{ route('package.inspection') }}" method="GET" class="row g-3 align-items-end">

                <div class="col-md-5">
                    <label class="form-label font-13 fw-semibold text-muted mb-1">Trạng thái kiện hàng</label>
                    <select name="tinh_trang" class="form-select form-select-sm">
                        <option value="">-- Tất cả trạng thái --</option>
                        <option value="cho_xu_ly" {{ request('tinh_trang') == 'cho_xu_ly' ? 'selected' : '' }}>Chờ xử lý
                        </option>
                        <option value="dang_o_kho_a" {{ request('tinh_trang') == 'dang_o_kho_a' ? 'selected' : '' }}>
                            Đang ở Kho TQ (Đang kiểm)</option>
                        <option value="dang_o_kho_b" {{ request('tinh_trang') == 'dang_o_kho_b' ? 'selected' : '' }}>Đã
                            về Kho VN</option>
                    </select>
                </div>

                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-sm text-white w-100 fw-semibold"
                        style="background-color: #20c997;">
                        <i class="bi bi-funnel"></i> Lọc
                    </button>
                    <a href="{{ route('package.inspection') }}" class="btn btn-sm btn-outline-secondary w-100">
                        Bỏ lọc
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- BẢNG DANH SÁCH -->
    <div class="bg-white shadow-sm rounded-2 p-3">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle font-14 mb-0">
                <thead class="text-center text-white" style="background-color: #20c997;">
                    <tr>
                        <th style="width: 5%;">STT</th>
                        <th style="width: 15%;">Mã Kiện Hàng</th>
                        <th style="width: 15%;">Thuộc Đơn</th>
                        <th style="width: 15%;">Kho Nhận (TQ)</th>
                        <th style="width: 20%;">Trạng Thái Hiện Tại</th>
                        <th style="width: 15%;">Kết Quả Kiểm</th>
                        <th style="width: 10%;">Chi Tiết</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($packages as $index => $pkg)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>

                        <td class="text-center">
                            <div class="fw-bold" style="color: #20c997;">{{ $pkg->ma_don_kien_hang }}</div>
                            <div class="text-muted font-12">{{ $pkg->ma_van_don }}</div>
                        </td>

                        <td class="text-center">
                            @if($pkg->order_id)
                            <span class="badge bg-info text-dark mb-1">Mua hộ</span>
                            <div class="font-12 fw-bold">#{{ $pkg->order->ma_don_hang ?? '' }}</div>
                            @elseif($pkg->consignment_order_id)
                            <span class="badge bg-success mb-1">Ký gửi</span>
                            <div class="font-12 fw-bold">#{{ $pkg->consignmentOrder->ma_don_ky_gui ?? '' }}</div>
                            @endif
                        </td>

                        <td class="text-center fw-semibold">{{ $pkg->khoNhan->ten_kho ?? '--' }}</td>

                        <td class="text-center">
                            @switch($pkg->tinh_trang)
                            @case('cho_xu_ly') <span class="badge bg-secondary">Chờ xử lý</span> @break
                            @case('xac_nhan_lai') <span class="badge bg-warning text-dark">Có vấn đề - Cần xác
                                nhận</span> @break
                            @case('dang_o_kho_a') <span class="badge bg-primary">Đã nhận tại TQ</span> @break
                            @case('dang_o_kho_b') <span class="badge bg-success">Đã xuất về VN</span> @break
                            @default <span class="badge bg-light text-dark">{{ $pkg->tinh_trang }}</span>
                            @endswitch
                        </td>

                        <td class="text-center">
                            <!-- Chỗ này bạn có thể bổ sung cột "ket_qua_kiem" trong DB sau này nếu muốn -->
                            @if($pkg->tinh_trang == 'dang_o_kho_a' || $pkg->tinh_trang == 'dang_o_kho_b')
                            <span class="text-success fw-bold"><i class="bi bi-check-circle"></i> Đã kiểm</span>
                            @elseif($pkg->tinh_trang == 'xac_nhan_lai')
                            <span class="text-danger fw-bold"><i class="bi bi-exclamation-triangle"></i> Thiếu/Sai
                                hàng</span>
                            @else
                            <span class="text-muted fst-italic">Chưa kiểm</span>
                            @endif
                        </td>

                        <td class="text-center">
                            <a href="{{ route('package.show', $pkg->id) }}" class="btn btn-sm text-white"
                                style="background-color: #20c997;" title="Xem chi tiết">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="bi bi-search fs-1 d-block mb-2" style="color: #20c997;"></i>
                            Bạn chưa có kiện hàng nào yêu cầu kiểm đếm.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection