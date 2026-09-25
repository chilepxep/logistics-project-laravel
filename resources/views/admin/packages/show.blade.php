@extends('layouts.admin')
@section('title', 'Chi tiết Kiện Hàng')
@section('page_title', 'Chi tiết Kiện: ' . $package->ma_don_kien_hang)

@section('content')

<style>
/* Đường kẻ dọc nền */
.tracking-timeline {
    position: relative;
    padding-left: 2rem;
    margin-bottom: 2rem;
    margin-top: 1rem;
}

.tracking-timeline::before {
    content: '';
    position: absolute;
    top: 0;
    bottom: 0;
    left: 7px;
    width: 2px;
    background-color: #dee2e6;
    /* Màu xám nhạt */
}

/* Từng mốc thời gian */
.timeline-item {
    position: relative;
    margin-bottom: 1.5rem;
}

/* Dấu chấm tròn (Dot) */
.timeline-item::before {
    content: '';
    position: absolute;
    top: 5px;
    left: -2rem;
    width: 16px;
    height: 16px;
    border-radius: 50%;
    background-color: #0d6efd;
    /* Màu xanh lam */
    border: 3px solid #fff;
    box-shadow: 0 0 0 1px #dee2e6;
    z-index: 2;
}

/* Highlight điểm mới nhất (Dòng đầu tiên) */
.timeline-item:first-child::before {
    background-color: #198754;
    /* Màu xanh lá (Success) */
    box-shadow: 0 0 0 2px #198754;
}

.timeline-item:first-child .tracking-title {
    color: #198754 !important;
}
</style>

<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 fw-bold">Thông tin chi tiết kiện hàng</h6>
        <div>

            @if(auth()->user()->vai_tro === 'admin' || (auth()->user()->vai_tro === 'nhan_vien' &&
            $package->tru_so_id == auth()->user()->warehouse_id))


            <a href="{{ route('admin.packages.edit', $package->id) }}" class="btn btn-sm btn-primary">
                <i class="bi bi-pencil-square"></i> Sửa
            </a>

            @else

            <!-- Khóa nút nếu là kiện hàng của kho khác -->
            <button class="btn btn-sm btn-secondary" disabled title="Kiện hàng này không nằm trong kho của bạn">
                <i class="bi bi-lock-fill"></i> Sửa
            </button>

            @endif
            <a href="{{ route('admin.packages.index') }}" class="btn btn-sm btn-secondary">
                <i class="bi bi-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>
    <div class="card-body p-4">

        <h6 class="fw-bold text-primary mb-3"><i class="bi bi-truck"></i> 1. Hành trình & Trạng thái</h6>
        <div class="row g-3 mb-4 bg-light p-3 rounded">
            <div class="col-md-6">
                <p class="text-muted mb-1">Vị trí hiện tại (Kho)</p>
                <h5 class="fw-bold text-success"><i class="bi bi-geo-alt-fill"></i>
                    {{ $package->warehouse->ten_kho ?? 'Chưa xác định' }}</h5>
            </div>
            <div class="col-md-6">
                <p class="text-muted mb-1">Trạng thái kiện hàng</p>
                <span
                    class="badge bg-info text-dark fs-6">{{ $package->trang_thai_hien_thi ?? $package->tinh_trang }}</span>
            </div>
            <div class="col-md-12 mt-3">
                <p class="text-muted mb-1">Thuộc về Đơn hàng:</p>
                @if($package->order_id)
                <div class="p-2 border border-primary rounded d-inline-block">
                    <span class="badge bg-primary me-2">ĐƠN MUA HỘ</span>
                    <a href="{{ route('admin.orders.show', $package->order_id) }}" class="fw-bold text-decoration-none">
                        {{ $package->order->ma_don_hang ?? 'Xem chi tiết' }}
                    </a>
                    <span class="text-muted ms-2">(Khách: {{ $package->order->user->ho_ten ?? 'N/A' }})</span>
                </div>
                @elseif($package->consignment_order_id)
                <div class="p-2 border border-secondary rounded d-inline-block">
                    <span class="badge bg-secondary me-2">ĐƠN KÝ GỬI</span>
                    <a href="{{ route('admin.consignment_orders.show', $package->consignment_order_id) }}"
                        class="fw-bold text-decoration-none text-secondary">
                        {{ $package->consignmentOrder->ma_don_ky_gui ?? 'Xem chi tiết' }}
                    </a>
                    <span class="text-muted ms-2">(Khách:
                        {{ $package->consignmentOrder->user->ho_ten ?? 'N/A' }})</span>
                </div>
                @else
                <span class="text-danger">Kiện hàng mồ côi (Không thuộc đơn nào)</span>
                @endif
            </div>
        </div>

        <h6 class="fw-bold text-primary mb-3"><i class="bi bi-box-seam"></i> 2. Thông số Kiện hàng</h6>
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <p class="text-muted mb-1">Mã vận đơn (Trung Quốc)</p>
                <h5 class="fw-bold">{{ $package->ma_van_don }}</h5>
            </div>
            <div class="col-md-4">
                <p class="text-muted mb-1">Trọng lượng</p>
                <h5 class="text-danger fw-bold">{{ $package->tong_kg ?? '0' }} <small class="text-muted">KG</small></h5>
            </div>
            <div class="col-md-4">
                <p class="text-muted mb-1">Thể tích</p>
                <h5 class="text-primary fw-bold">{{ $package->tong_m3 ?? '0' }} <small class="text-muted">M3</small>
                </h5>
            </div>
            <div class="col-md-6">
                <p class="text-muted mb-1">Loại hàng hoá</p>
                <p class="fw-bold">{{ $package->loai_hang ?? '---' }}</p>
            </div>
            <div class="col-md-6">
                <p class="text-muted mb-1">Ghi chú kho</p>
                <p class="fw-bold">{{ $package->ghi_chu ?? '---' }}</p>
            </div>
        </div>

        <h6 class="fw-bold text-primary mb-3"><i class="bi bi-cash-stack"></i> 3. Phí dịch vụ & Cước</h6>
        <div class="row g-3">
            <div class="col-md-3">
                <p class="text-muted mb-1">Phí nội địa TQ</p>
                <p class="fw-bold">{{ number_format($package->phi_van_chuyen_noi_dia) }} đ</p>
            </div>
            <div class="col-md-3">
                <p class="text-muted mb-1">Phí khác (Đóng gỗ...)</p>
                <p class="fw-bold">{{ number_format($package->phi_khac) }} đ</p>
            </div>
            <div class="col-md-3">
                <p class="text-muted mb-1">Chiết khấu giảm trừ</p>
                <p class="fw-bold text-success">- {{ number_format($package->chiet_khau) }} đ</p>
            </div>
            <div class="col-md-3">
                <p class="text-muted mb-1">Thành tiền Cước VC</p>
                <h4 class="text-danger fw-bold">{{ number_format($package->thanh_tien) }} đ</h4>
            </div>
        </div>

    </div>

    <div class="card mt-4 shadow-sm border-0">
        <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
            <h5 class="mb-0 fw-bold">
                <i class="bi bi-clock-history me-2 text-primary"></i> Lịch sử hành trình
            </h5>
        </div>

        <div class="card-body">
            <!-- Kiểm tra xem kiện hàng đã có lịch sử chưa -->
            @if($package->trackings && $package->trackings->count() > 0)
            <div class="tracking-timeline">

                <!-- Vòng lặp in danh sách Tracking (đã được sort mới nhất lên đầu trong Model) -->
                @foreach($package->trackings as $tracking)
                <div class="timeline-item">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <h6 class="mb-0 fw-bold tracking-title text-dark">
                            {{ $tracking->title }}
                        </h6>
                        <span class="text-muted font-13" style="font-size: 13px;">
                            <i class="bi bi-calendar-event me-1"></i>
                            {{ $tracking->created_at->format('d/m/Y - H:i') }}
                        </span>
                    </div>

                    <p class="mb-2 text-muted" style="font-size: 14px;">
                        {{ $tracking->description }}
                    </p>

                    <!-- Hiển thị người cập nhật và vị trí kho -->
                    <div class="mt-1" style="font-size: 12px;">
                        @if($tracking->warehouse)
                        <span class="badge bg-light text-dark border me-2 py-1 px-2">
                            <i class="bi bi-geo-alt-fill text-danger me-1"></i>
                            {{ $tracking->warehouse->ten_kho }}
                        </span>
                        @endif

                        @if($tracking->employee)
                        <span class="badge bg-light text-muted border py-1 px-2">
                            <i class="bi bi-person-fill me-1"></i>
                            {{ $tracking->employee->ho_ten }}
                        </span>
                        @endif
                    </div>
                </div>
                @endforeach

            </div>
            @else
            <!-- Nếu chưa có dữ liệu -->
            <div class="alert alert-secondary text-center border-0 py-4">
                <i class="bi bi-box-seam fs-3 text-muted d-block mb-2"></i>
                Chưa có dữ liệu lịch sử hành trình cho kiện hàng này.
            </div>
            @endif
        </div>
    </div>
</div>
@endsection