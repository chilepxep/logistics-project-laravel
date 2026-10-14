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

<div class="container-fluid mt-4 px-4 pb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="text-uppercase fw-bold m-0" style="color: #0b3a68;">
            <i class="bi bi-clock-history me-2"></i> Lịch sử giao dịch
        </h3>


        <a href="{{ route('withdrawal.index') }}" class="btn btn-warning fw-semibold shadow-sm text-dark">
            <i class="bi bi-cash-coin me-1"></i> Yêu cầu rút tiền
        </a>
    </div>

    <!-- KHỐI BẢNG LỊCH SỬ -->
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle font-14 mb-0">
                    <thead class="text-center text-white" style="background-color: #0b3a68;">
                        <tr>
                            <th style="width: 5% py-3">STT</th>
                            <th style="width: 15%;">Thời gian</th>
                            <th style="width: 15%;">Loại giao dịch</th>
                            <th style="width: 30%;">Nội dung</th>
                            <th style="width: 15%;">Phát sinh (VNĐ)</th>
                            <th style="width: 20%;">Số dư cuối (VNĐ)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $index => $trans)
                        <tr>
                            <!-- Tính số thứ tự liên tục khi phân trang -->
                            <td class="text-center">
                                {{ ($transactions->currentPage() - 1) * $transactions->perPage() + $index + 1 }}</td>

                            <td class="text-center fw-semibold text-muted">
                                {{ \Carbon\Carbon::parse($trans->thoi_gian)->format('d/m/Y H:i:s') }}
                            </td>

                            <td class="text-center">
                                @switch($trans->loai_giao_dich)
                                @case('nap_tien')
                                <span class="badge bg-success px-2 py-1"><i class="bi bi-arrow-down-circle"></i> Nạp
                                    tiền</span>
                                @break
                                @case('hoan_tien')
                                <span class="badge bg-info text-dark px-2 py-1"><i class="bi bi-arrow-return-left"></i>
                                    Hoàn tiền</span>
                                @break
                                @case('rut_tien')
                                <span class="badge bg-warning text-dark px-2 py-1"><i class="bi bi-arrow-up-circle"></i>
                                    Rút tiền</span>
                                @break
                                @case('dat_hang')
                                <span class="badge bg-primary px-2 py-1"><i class="bi bi-cart-check"></i> Đặt cọc</span>
                                @break
                                @case('thanh_toan')
                                <span class="badge bg-danger px-2 py-1"><i class="bi bi-receipt"></i> Thanh toán</span>
                                @break
                                @default
                                <span class="badge bg-secondary">{{ $trans->loai_giao_dich }}</span>
                                @endswitch
                            </td>

                            <td>{{ $trans->thong_tin ?? '--' }}</td>

                            <!-- Xử lý màu sắc và dấu (+/-) cho Phát sinh -->
                            <td class="text-end fw-bold fs-6">
                                @if(in_array($trans->loai_giao_dich, ['nap_tien', 'hoan_tien']))
                                <span class="text-success">+
                                    {{ number_format($trans->gia_tri_giao_dich, 0, ',', '.') }}</span>
                                @else
                                <span class="text-danger">-
                                    {{ number_format($trans->gia_tri_giao_dich, 0, ',', '.') }}</span>
                                @endif
                            </td>

                            <!-- Số dư hiện tại (cuối kỳ) -->
                            <td class="text-end fw-bold text-primary fs-6 bg-light">
                                {{ number_format($trans->so_du_hien_tai, 0, ',', '.') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-journal-x fs-1 d-block mb-2"></i>
                                Chưa có bất kỳ giao dịch nào phát sinh.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Khối hiển thị phân trang -->
        @if($transactions->hasPages())
        <div class="card-footer bg-white d-flex justify-content-end py-3">
            {{ $transactions->links('pagination::bootstrap-5') }}
        </div>
        @endif
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

@endsection