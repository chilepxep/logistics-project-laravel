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
            <h5 class="text-danger fw-bold mb-0">024.6680.3049</h5>
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

    <!-- Tỉ giá -->
    <div class="d-flex align-items-center text-end">
        <i class="bi bi-cash-coin text-warning fs-1 me-2"></i>
        <div>
            <small class="text-muted fw-bold">TỈ GIÁ</small>
            <h5 class="text-danger fw-bold mb-0">3,520 đ</h5>
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



@endsection