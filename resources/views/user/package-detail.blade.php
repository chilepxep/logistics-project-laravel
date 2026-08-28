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


<div class="container-fluid mt-4 px-4">
    <!-- Nút quay lại và Tiêu đề -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('package.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Quay lại
            </a>
            <h3 class="text-uppercase fw-bold m-0" style="color: #6f42c1;">
                Chi tiết kiện hàng: <span class="text-primary">{{ $package->ma_don_kien_hang }}</span>
            </h3>
        </div>
        <div>
            @switch($package->tinh_trang)
            @case('cho_xu_ly') <span class="badge bg-secondary px-3 py-2 fs-6">Chờ xử lý</span> @break
            @case('xac_nhan_lai') <span class="badge bg-warning text-dark px-3 py-2 fs-6">Xác nhận lại</span> @break
            @case('da_dat_hang') <span class="badge bg-info text-dark px-3 py-2 fs-6">Đã đặt hàng</span> @break
            @case('dang_o_kho_a') <span class="badge bg-primary px-3 py-2 fs-6">Đang ở Kho TQ</span> @break
            @case('dang_o_kho_b') <span class="badge bg-primary px-3 py-2 fs-6">Đang ở Kho VN</span> @break
            @case('dang_giao_hang') <span class="badge bg-warning text-dark px-3 py-2 fs-6">Đang giao hàng</span> @break
            @case('cho_cod') <span class="badge bg-dark px-3 py-2 fs-6">Chờ COD</span> @break
            @case('da_huy') <span class="badge bg-danger px-3 py-2 fs-6">Đã hủy</span> @break
            @endswitch
        </div>
    </div>

    <div class="row">
        <!-- Khối 1: Thông tin kiện hàng -->
        <div class="col-md-7 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header fw-bold text-uppercase text-white" style="background-color: #6f42c1;">
                    <i class="bi bi-info-circle me-1"></i> Thông tin chung
                </div>
                <div class="card-body font-14">
                    <table class="table table-borderless mb-0">
                        <tbody>
                            <tr>
                                <td class="text-muted" style="width: 40%;">Mã vận đơn (Tracking):</td>
                                <td class="fw-bold fs-6 text-dark">{{ $package->ma_van_don }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Liên kết đơn hàng:</td>
                                <td>
                                    @if($package->order_id)
                                    <span class="badge bg-info text-dark">Mua hộ</span>
                                    <a href="{{ route('order.show', $package->order_id) }}"
                                        class="fw-bold text-decoration-none ms-1">#{{ $package->order->ma_don_hang }}</a>
                                    @elseif($package->consignment_order_id)
                                    <span class="badge bg-success">Ký gửi</span>
                                    <a href="{{ route('consignment.show', $package->consignment_order_id) }}"
                                        class="fw-bold text-decoration-none ms-1">#{{ $package->consignmentOrder->ma_don_ky_gui }}</a>
                                    @else
                                    <span class="fst-italic text-muted">Chưa liên kết</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted">Kho nhận hàng:</td>
                                <td class="fw-semibold">{{ $package->khoNhan->ten_kho ?? '--' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Loại hàng hóa:</td>
                                <td class="fw-semibold">{{ $package->loai_hang ?? 'Chưa cập nhật' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Ghi chú của khách:</td>
                                <td>{{ $package->ghi_chu ?? '--' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Khối 2: Cân nặng & Chi phí -->
        <div class="col-md-5 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-light fw-bold text-uppercase" style="color: #6f42c1;">
                    <i class="bi bi-calculator me-1"></i> Chỉ số & Chi phí
                </div>
                <div class="card-body font-14">
                    <div class="d-flex justify-content-between border-bottom pb-2 mb-2">
                        <span class="text-muted">Cân nặng thực tế:</span>
                        <span class="fw-bold">{{ $package->tong_kg ?? 0 }} kg</span>
                    </div>
                    <div class="d-flex justify-content-between border-bottom pb-2 mb-2">
                        <span class="text-muted">Khối lượng quy đổi:</span>
                        <span class="fw-bold">{{ $package->tong_m3 ?? 0 }} m³</span>
                    </div>
                    <div class="d-flex justify-content-between pb-2 mb-2">
                        <span class="text-muted">Phí VC Nội địa (TQ):</span>
                        <span>{{ number_format($package->phi_van_chuyen_noi_dia, 0, ',', '.') }} đ</span>
                    </div>
                    <div class="d-flex justify-content-between pb-2 mb-2">
                        <span class="text-muted">Các phụ phí khác:</span>
                        <span>{{ number_format($package->phi_khac, 0, ',', '.') }} đ</span>
                    </div>
                    <div class="d-flex justify-content-between pb-2 mb-2">
                        <span class="text-muted">Chiết khấu:</span>
                        <span class="text-success">- {{ number_format($package->chiet_khau, 0, ',', '.') }} đ</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center bg-light p-2 rounded">
                        <span class="fw-bold text-uppercase">Thành tiền:</span>
                        <span class="fw-bold fs-5 text-danger">{{ number_format($package->thanh_tien, 0, ',', '.') }}
                            đ</span>
                    </div>
                    <small class="text-muted d-block mt-2 fst-italic">* Các chi phí và cân nặng sẽ được cập nhật khi
                        hàng về tới kho.</small>
                </div>
            </div>
        </div>

        <!-- Khối 3: Thông tin giao nhận (Deliveries) -->
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-light fw-bold text-uppercase" style="color: #0b3a68;">
                    <i class="bi bi-truck me-1"></i> Thông tin giao hàng tận nơi
                </div>
                <div class="card-body font-14">
                    @if($package->delivery)
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <div class="text-muted mb-1">Phương thức vận chuyển:</div>
                            <div class="fw-bold text-uppercase">
                                {{ str_replace('_', ' ', $package->delivery->phuong_thuc_van_chuyen) }}</div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="text-muted mb-1">Thanh toán phí Ship:</div>
                            <div class="fw-bold text-uppercase">
                                {{ str_replace('_', ' ', $package->delivery->phuong_thuc_thanh_toan) }}</div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="text-muted mb-1">Mã vận đơn (Nội địa VN):</div>
                            <div class="fw-bold text-primary">{{ $package->delivery->ma_van_don ?? 'Chưa có' }}</div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="text-muted mb-1">Tình trạng giao:</div>
                            @if($package->delivery->trang_thai == 'cho_xu_ly') <span class="badge bg-secondary">Chờ xử
                                lý</span>
                            @elseif($package->delivery->trang_thai == 'dang_xu_ly') <span
                                class="badge bg-warning text-dark">Đang giao hàng</span>
                            @elseif($package->delivery->trang_thai == 'da_hoan_thanh') <span class="badge bg-success">Đã
                                giao xong</span>
                            @else <span class="badge bg-danger">Đã hủy</span> @endif
                        </div>
                        <div class="col-12 mt-2">
                            <div class="text-muted mb-1">Địa chỉ nhận hàng:</div>
                            <div class="p-2 bg-light border rounded">
                                {{ $package->delivery->thong_tin_giao_hang ?? 'Chưa cập nhật' }}</div>
                        </div>
                    </div>
                    @else
                    <div class="text-center py-4 text-muted">
                        <i class="bi bi-house-door fs-2 d-block mb-2"></i>
                        Kiện hàng này chưa có yêu cầu giao hàng tận nơi.
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection