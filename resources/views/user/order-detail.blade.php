@extends('layouts.user')

@section('title', 'Tổng quan')

@section('content')

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
    <!-- Nút quay lại và Tiêu đề -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('list.order') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Quay lại
            </a>
            <h3 class="text-uppercase fw-bold m-0" style="color: #0b3a68;">
                Chi tiết đơn mua hộ: <span class="text-primary">#{{ $order->ma_don_hang }}</span>
            </h3>
        </div>
        <div>
            @if($order->trang_thai == 'cho_bao_gia')
            <span class="badge bg-warning text-dark px-3 py-2 fs-6">Chờ báo giá</span>
            @elseif($order->trang_thai == 'can_xac_nhan_lai')
            <span class="badge bg-info text-dark px-3 py-2 fs-6">Cần xác nhận lại</span>
            @elseif($order->trang_thai == 'da_hoan_thanh')
            <span class="badge bg-success px-3 py-2 fs-6">Đã hoàn thành</span>
            @else
            <span class="badge bg-secondary px-3 py-2 fs-6">Đã hủy</span>
            @endif
        </div>
    </div>

    <!-- Thông tin chung của đơn hàng -->
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-header bg-light fw-bold text-uppercase">
            <i class="bi bi-info-circle me-1"></i> Thông tin chung
        </div>
        <div class="card-body row font-14">
            <div class="col-md-6 mb-2">
                <span class="text-muted">Ngày tạo:</span>
                <span class="fw-semibold">{{ $order->created_at->format('d/m/Y H:i') }}</span>
            </div>
            <div class="col-md-6 mb-2">
                <span class="text-muted">Kho nhận hàng (VN):</span>
                <span class="fw-semibold">{{ $order->khoNhan->ten_kho ?? 'N/A' }}</span>
            </div>
            <div class="col-md-6 mb-2">
                <span class="text-muted">Yêu cầu tốc độ:</span>
                <span
                    class="fw-semibold text-danger">{{ $order->yeu_cau_toc_do == 'nhanh' ? 'Nhanh' : 'Thường' }}</span>
            </div>
            <div class="col-md-6 mb-2">
                <span class="text-muted">Tổng tiền:</span>
                <span class="fw-bold text-danger fs-5">{{ number_format($order->tong_tien, 0, ',', '.') }} VNĐ</span>
            </div>
        </div>
    </div>

    <!-- Danh sách sản phẩm (Items) -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-light fw-bold text-uppercase">
            <i class="bi bi-box me-1"></i> Danh sách sản phẩm
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0 font-14">
                    <thead class="table-light text-center">
                        <tr>
                            <th style="width: 5%;">STT</th>
                            <th style="width: 10%;">Hình ảnh</th>
                            <th style="width: 25%;">Tên sản phẩm</th>
                            <th style="width: 15%;">Thuộc tính (Màu, Size)</th>
                            <th style="width: 10%;">Số lượng</th>
                            <th style="width: 15%;">Đơn giá (¥)</th>
                            <th style="width: 20%;">Ghi chú</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($order->items as $index => $item)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td class="text-center">
                                @if($item->hinh_anh_url)
                                <img src="{{ $item->hinh_anh_url }}" alt="sp"
                                    style="width: 60px; height: 60px; object-fit: cover;" class="border rounded">
                                @else
                                <div class="bg-secondary text-white d-flex align-items-center justify-content-center rounded"
                                    style="width: 60px; height: 60px;">No IMG</div>
                                @endif
                            </td>
                            <td>
                                <!-- Tuỳ vào tên cột trong DB của bạn mà sửa lại cho đúng nhé -->
                                <a href="{{ $item->link_san_pham ?? '#' }}" target="_blank"
                                    class="text-decoration-none fw-semibold">
                                    {{ $item->ten_san_pham ?? 'Chưa cập nhật' }}
                                </a>
                            </td>
                            <td class="text-center">{{ $item->mau_sac_kich_thuoc ?? '--' }}</td>
                            <td class="text-center fw-bold">{{ $item->so_luong }}</td>
                            <td class="text-center text-danger fw-semibold">{{ number_format($item->don_gia, 2) }} ¥
                            </td>
                            <td>{{ $item->ghi_chu_khac ?? '' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">Không có sản phẩm nào trong đơn hàng
                                này.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


@endsection