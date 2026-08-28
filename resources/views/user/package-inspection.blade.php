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


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection