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



<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="text-uppercase fw-bold m-0" style="color: #6f42c1;">
        <i class="bi bi-box2-fill me-2"></i> Danh sách kiện hàng
    </h3>
    <!-- THÊM ĐOẠN NÀY VÀO -->
    <a href="{{ route('package.create') }}" class="btn text-white fw-semibold" style="background-color: #6f42c1;">
        <i class="bi bi-plus-lg me-1"></i> Thêm kiện hàng
    </a>
</div>

<div class="bg-white shadow-sm rounded-2 p-3">
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle font-14 mb-0">
            <thead class="text-center text-white" style="background-color: #6f42c1;">
                <tr>
                    <th style="width: 5%;">STT</th>
                    <th style="width: 15%;">Mã Kiện / Mã Vận Đơn</th>
                    <th style="width: 15%;">Thuộc Đơn</th>
                    <th style="width: 15%;">Kho Nhận</th>
                    <th style="width: 12%;">Cân nặng / Khối</th>
                    <th style="width: 13%;">Thành Tiền</th>
                    <th style="width: 15%;">Tình Trạng</th>
                    <th style="width: 10%;">Thao Tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($packages as $index => $pkg)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>
                        <div class="fw-bold text-primary">{{ $pkg->ma_don_kien_hang }}</div>
                        <div class="text-muted font-12"><i class="bi bi-upc-scan"></i> {{ $pkg->ma_van_don }}</div>
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
                    <td class="text-center">{{ $pkg->khoNhan->ten_kho ?? '--' }}</td>
                    <td class="text-center">
                        <div><span class="fw-bold">{{ $pkg->tong_kg ?? 0 }}</span> kg</div>
                        <div class="text-muted"><span class="fw-bold">{{ $pkg->tong_m3 ?? 0 }}</span> m³</div>
                    </td>
                    <td class="text-end text-danger fw-bold">
                        {{ number_format($pkg->thanh_tien, 0, ',', '.') }} đ
                    </td>
                    <td class="text-center">
                        @switch($pkg->tinh_trang)
                        @case('cho_xu_ly')
                        <span class="badge bg-secondary">Chờ xử lý</span> @break
                        @case('xac_nhan_lai')
                        <span class="badge bg-warning text-dark">Xác nhận lại</span> @break
                        @case('da_dat_hang')
                        <span class="badge bg-info text-dark">Đã đặt hàng</span> @break
                        @case('dang_o_kho_a')
                        <span class="badge bg-primary">Đang ở Kho TQ</span> @break
                        @case('dang_o_kho_b')
                        <span class="badge bg-primary">Đang ở Kho VN</span> @break
                        @case('dang_giao_hang')
                        <span class="badge bg-warning text-dark">Đang giao hàng</span> @break
                        @case('cho_cod')
                        <span class="badge bg-dark">Chờ COD</span> @break
                        @case('da_huy')
                        <span class="badge bg-danger">Đã hủy</span> @break
                        @default
                        <span class="badge bg-light text-dark">{{ $pkg->tinh_trang }}</span>
                        @endswitch
                    </td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-1">
                            <a href="{{ route('package.show', $pkg->id) }}" class="btn btn-sm btn-info text-white"
                                title="Xem chi tiết">
                                <i class="bi bi-eye"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-5 text-muted">
                        <i class="bi bi-box-seam fs-1 d-block mb-2 text-secondary"></i>
                        Bạn chưa có kiện hàng nào trong hệ thống.
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